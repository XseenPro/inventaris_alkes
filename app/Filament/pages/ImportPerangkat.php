<?php

namespace App\Filament\Pages;

use App\Models\Perangkat;
use App\Models\Jenis;
use App\Models\Lokasi;
use App\Models\Kondisi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Imports\Traits\MapsMaster;
use Filament\Actions\Action;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\ViewField;



class ImportPerangkat extends Page implements Forms\Contracts\HasForms
{
  use Forms\Concerns\InteractsWithForms;
  use MapsMaster;

  // protected static ?string $navigationIcon  = 'heroicon-o-arrow-up-tray';
  protected static ?string $navigationLabel = 'Import Perangkat (Preview)';
  protected static ?string $title           = 'Import Perangkat (Preview)';
  protected static ?string $slug            = 'perangkat/import-preview';
  // protected static ?string $navigationGroup = 'Manajemen Inventaris';

  public array $data = [
    'file'   => null,
    'policy' => 'skip',
  ];
  public array $dupes = [];
  public int $totalRows = 0;
  // public array $selective = [];
  public ?string $scanToken = null;
  public array $headers = [];
  public array $previewRows = [];
  public int $previewLimit = 50;
  protected int $skippedNoName = 0;
  protected int $skippedDupes = 0;

  public function form(Schema $form): Schema
  {
    return $form->schema([
      Section::make('Upload File')
        ->description('Unggah Excel, klik Scan untuk melihat duplikat sebelum import.')
        ->schema([
          Forms\Components\FileUpload::make('file')
            ->label('File Excel')
            ->acceptedFileTypes([
              'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
              'application/vnd.ms-excel',
            ])
            ->directory('imports')
            ->disk('public')
            ->required(),
          Forms\Components\Radio::make('policy')
            ->label('Kebijakan saat duplikat')
            ->options([
              'skip'      => 'Skip semua duplikat',
              'overwrite' => 'Overwrite semua duplikat',
              'selective' => 'Pilih per item (checklist)',
            ])
            ->default('skip')
            ->afterStateUpdated(function ($set, $state) {
              if ($state !== 'selective') {
                $set('selective', []);
              }
            })
            ->inline(),
          Actions::make([
            Action::make('scan')
              ->label('Scan')
              ->action('scanFile')
              ->color('primary')
              ->icon('heroicon-o-magnifying-glass'),
          ])->alignLeft(),
        ])->columns(2),
      Section::make('Preview Isi File')
        ->description('Cuplikan isi file setelah dinormalisasi header (maks. ' . $this->previewLimit . ' baris).')
        ->schema([
          ViewField::make('preview-table')
            ->view('filament.import.preview-table')  // path view BENAR
            ->visible(fn() => $this->scanToken !== null)

        ])
        ->visible(fn() => $this->scanToken !== null),
      Section::make('Preview Duplikat')
        ->description('Nomor inventaris yang sudah ada di database.')
        ->schema([
          ViewField::make('preview-summary')
            ->view('filament.import.preview-summary')  // path view BENAR
            ->visible(fn() => $this->scanToken !== null),

          Forms\Components\CheckboxList::make('selective')
            ->options(fn() => collect($this->dupes)
              ->map(fn($n) => strtoupper(trim((string)$n)))
              ->unique()
              ->mapWithKeys(fn($n) => [$n => $n])
              ->all())
            ->columns(2)
            ->reactive()
            ->bulkToggleable(false)
            ->visible(fn() => $this->scanToken !== null && ($this->data['policy'] ?? 'skip') === 'selective'),
          Actions::make([
            Action::make('run')
              ->label('Jalankan Import')
              ->action('runImport')
              ->color('success')
              ->icon('heroicon-o-play')
              ->requiresConfirmation()
              ->visible(fn() => $this->scanToken !== null),
          ])->alignLeft(),
        ]),
    ])->statePath('data');
  }

  protected string $view = 'filament.pages.import-perangkat';

  public function scanFile(): void
  {
    $state = $this->form->getState();
    if (empty($state['file'])) {
      Notification::make()->title('File belum dipilih')->danger()->send();
      return;
    }

    $this->data['policy'] = $state['policy'] ?? 'skip';

    $fullPath = Storage::disk('public')->path($state['file']);

    $collector = new class($this) implements ToCollection, WithHeadingRow {
      public array $rows = [];
      public function __construct(private ImportPerangkat $page) {}

      // TAMBAH INI
      public function headingRow(): int
      {
        return 2;  // Baris ke-2 adalah header: "No", "Tanggal Entry", dll
      }

      public function collection(Collection $collection)
      {
        foreach ($collection as $row) {
          $raw = array_change_key_case($row->toArray(), CASE_LOWER);
          $raw = $this->page->normalizeRowKeys($raw);
          $this->rows[] = $raw;
        }
      }
    };


    Excel::import($collector, $fullPath);

    $rows = $collector->rows;
    $this->totalRows = count($rows);
    $allKeys = [];
    foreach ($rows as $r) {
      foreach (array_keys($r) as $k) {
        $allKeys[$k] = true;
      }
    }
    $preferred = [
      'nomor_inventaris',
      'nama_perangkat',
      'jenis',
      'lokasi',
      'status',
      'kondisi',
      'kategori',
      'kode_kategori',
      'tipe',
      'spesifikasi',
      'deskripsi',
      'perolehan',
      'tahun_pengadaan',
      'tanggal_entry',
      'tanggal_pembelian',
      'sumber_pendanaan',
      'harga_beli_non_ppn',
      'harga_beli_ppn',
      'keterangan',
      'catatan',
    ];


    $others = array_values(array_diff(array_keys($allKeys), $preferred));
    $this->headers = array_values(array_unique(array_merge($preferred, $others)));

    $this->previewRows = array_slice($rows, 0, $this->previewLimit);
    $numbers = [];
    foreach ($rows as $r) {
      $n = strtoupper(trim((string) ($r['nomor_inventaris'] ?? '')));
      if ($n !== '') $numbers[] = $n;
    }
    $numbers = array_values(array_unique($numbers));

    $exist = Perangkat::query()
      ->whereIn('nomor_inventaris', $numbers)
      ->pluck('nomor_inventaris')
      ->all();

    $this->dupes = $exist;
    $this->data['selective'] = [];

    $this->scanToken = (string) Str::uuid();
    cache()->put("import_scan:{$this->scanToken}", [
      'file'   => $state['file'],
      'policy' => $this->data['policy'],
      'dupes'  => $this->dupes,
      'total'  => $this->totalRows,
    ], now()->addMinutes(30));

    Notification::make()->title('Scan selesai')->success()->send();
  }

  public function runImport(): void
  {
    if (!$this->scanToken) {
      Notification::make()->title('Belum dilakukan scan')->danger()->send();
      return;
    }
    $scan = cache()->pull("import_scan:{$this->scanToken}");
    if (!$scan) {
      Notification::make()->title('Sesi scan kedaluwarsa, scan ulang')->danger()->send();
      return;
    }

    $filePath = Storage::disk('public')->path($scan['file']);
    $policy   = $this->data['policy'] ?? 'skip';

    $lokasiMap  = Lokasi::pluck('id', 'nama_lokasi')->all();
    $jenisMap   = Jenis::pluck('id', 'nama_jenis')->all();
    $kondisiMap = Kondisi::pluck('id', 'nama_kondisi')->all();

    $collector = new class($this) implements ToCollection, WithHeadingRow {
      public array $rows = [];
      public function __construct(private ImportPerangkat $page) {}

      // TAMBAH INI JUGA
      public function headingRow(): int
      {
        return 2;
      }

      public function collection(Collection $collection)
      {
        foreach ($collection as $row) {
          $raw = array_change_key_case($row->toArray(), CASE_LOWER);
          $raw = $this->page->normalizeRowKeys($raw);
          $this->rows[] = $raw;
        }
      }
    };

    Excel::import($collector, $filePath);
    $rows = $collector->rows;

    $allowOverwrite = [];
    if ($policy === 'selective') {
      $allowOverwrite = collect($this->data['selective'] ?? [])
        ->map(fn($n) => strtoupper(trim((string) $n)))
        ->unique()
        ->values()
        ->all();
    }

    $inserted = 0;
    $updated  = 0;
    $this->skippedNoName = 0;
    $this->skippedDupes  = 0;

    foreach ($rows as $row) {
      $nama = trim((string) ($row['nama_perangkat'] ?? ''));
      if ($nama === '') {
        $this->skippedNoName++;
        continue;
      }

      $nRaw  = strtoupper(trim((string) ($row['nomor_inventaris'] ?? '')));
      $empty = ['NAN', 'NA', 'N/A', '-', '—', '--', '0', '000', '#N/A', 'NULL', '(BLANK)'];
      $valid = (bool) preg_match('/^[A-Z0-9.\-\/]+$/', $nRaw);
      $nomor = (!$valid || in_array($nRaw, $empty, true)) ? null : $nRaw;

      $tahun = isset($row['tahun_pengadaan']) && trim((string) $row['tahun_pengadaan']) !== ''
        ? (int) $row['tahun_pengadaan']
        : (int) now()->year;

      $getOrCreate = function (array &$map, string $modelClass, string $column, ?string $raw) {
        $name = trim((string) ($raw ?? ''));
        if ($name === '') return null;
        if (isset($map[$name])) return $map[$name];
        $id = $modelClass::where($column, $name)->value('id');
        if ($id) {
          $map[$name] = $id;
          return $id;
        }
        $created = $modelClass::create([$column => $name]);
        $map[$name] = $created->id;
        return $created->id;
      };
      $lokasi_id  = $getOrCreate($lokasiMap,  Lokasi::class,         'nama_lokasi',  $row['lokasi']  ?? null);
      $jenis_id_x = $getOrCreate($jenisMap,   Jenis::class, 'nama_jenis',   $row['jenis']   ?? null);
      $kondisi_id = $getOrCreate($kondisiMap, Kondisi::class,        'nama_kondisi', $row['kondisi'] ?? null);

      $tanggalEntry = $this->parseTanggal($row['tanggal_entry'] ?? null);
      $tanggalPembelian = $this->parseTanggal($row['tanggal_pembelian'] ?? null);
      $hargaNonPpn = !empty($row['harga_beli_non_ppn'])
        ? (int) preg_replace('/\D+/', '', (string) $row['harga_beli_non_ppn'])
        : null;

      $hargaPpn = !empty($row['harga_beli_ppn'])
        ? (int) preg_replace('/\D+/', '', (string) $row['harga_beli_ppn'])
        : null;
      $kode  = null;
      if (!empty($row['kode'])) {
        $k = trim((string) $row['kode']);
        $kode = $k !== '' && $k[0] !== '=' ? $k : null;
      }

      $jenis_id_resolved    = null;
      $kategori_id_resolved = null;

      $excelKategoriNama = trim((string)($row['kategori'] ?? ''));
      $excelKategoriKode = $this->normalizeKategoriKode($row['kode_kategori'] ?? null);
      $excelJenisNama    = trim((string)($row['jenis'] ?? ''));

      if ($excelKategoriKode) {
        $kategori_id_resolved = $this->resolveOrCreateKategoriByKode($excelKategoriKode, $excelKategoriNama ?: $nama);
      } elseif ($excelKategoriNama !== '') {
        $lookup = mb_strtolower($excelKategoriNama);
        $kategori_id_resolved = $this->kategoriMap[$lookup]
          ?? \App\Models\Kategori::whereRaw('LOWER(nama_kategori)=?', [$lookup])->value('id');
        if (!$kategori_id_resolved) {
          $kodeBaru = $this->nextKategoriKode();
          $kat = \App\Models\Kategori::create([
            'nama_kategori' => $excelKategoriNama,
            'kode_kategori' => $kodeBaru,
          ]);
          $this->kategoriMap[$lookup] = $kat->id;
          $this->kategoriCodeMap[$kat->kode_kategori] = $kat->id;
          $kategori_id_resolved = $kat->id;
        }
      }

      if ($excelJenisNama !== '') {
        $jenisModel = $this->resolveOrCreateJenisByName($excelJenisNama);
        if ($jenisModel) $jenis_id_resolved = (int)$jenisModel->id;
      }

      if ($nomor !== null && ($parts = $this->parseNomorInventaris($nomor))) {
        $tahun = $parts['tahun'];
        if (!$jenis_id_resolved) {
          $jenis_id_resolved = $this->resolveOrUpsertJenisFromNI($parts['prefix'], $parts['kode_jenis']);
        }
        if (!$kategori_id_resolved) {
          $kategori_id_resolved = $this->resolveOrCreateKategoriByKode($parts['kode_kat'], $excelKategoriNama ?: $nama);
        }
      }
      if ($nomor === null) {
        $nomor = \App\Support\NomorInventarisGenerator::generate(
          $jenis_id_resolved,
          $kategori_id_resolved,
          $tahun
        );
      }

      if (!$kategori_id_resolved) {
        $katModel = $this->resolveKategoriByNamaPerangkat($nama);
        if ($katModel) $kategori_id_resolved = (int)$katModel->id;
      }
      if (!$jenis_id_resolved) {
        $jenisModel = $this->resolveOrCreateJenisByName($excelJenisNama ?: 'Hardware');
        if ($jenisModel) $jenis_id_resolved = (int)$jenisModel->id;
      }

      if ($nomor !== null) {
        $existing = Perangkat::where('nomor_inventaris', $nomor)->first();
        if ($existing) {
          if ($policy === 'overwrite' || ($policy === 'selective' && in_array($nomor, $allowOverwrite, true))) {
            $existing->fill([
              'nama_perangkat'     => $nama,
              'nomor_inventaris' => $nomor,
              'tipe'               => $row['tipe'] ?? null,
              'spesifikasi'        => $row['spesifikasi'] ?? null,
              'deskripsi'          => $row['deskripsi'] ?? null,
              'perolehan'          => $row['perolehan'] ?? null,
              'tahun_pengadaan'    => $tahun,
              'catatan'            => $row['catatan'] ?? null,
              'mutasi'             => $row['mutasi'] ?? null,
              'upgrade'            => $row['upgrade'] ?? null,
              'kode'               => $kode,
              'lokasi_id'          => $lokasi_id,
              'jenis_id'           => $jenis_id_resolved ?? $jenis_id_x,
              'kondisi_id'         => $kondisi_id,
              'kategori_id'        => $kategori_id_resolved ?? $existing->kategori_id,

              'tanggal_entry'      => $tanggalEntry,
              'merek_alat'         => $row['merek_alat'] ?? null,
              'nomor_seri'         => $row['nomor_seri'] ?? null,
              'no_akl_akd'         => $row['no_akl_akd'] ?? null,
              'produk'             => $row['produk'] ?? null,
              'tanggal_pembelian'  => $tanggalPembelian,
              'sumber_pendanaan'   => $row['sumber_pendanaan'] ?? null,
              'harga_beli_non_ppn' => $hargaNonPpn,
              'harga_beli_ppn'     => $hargaPpn,
              'keterangan'         => $row['keterangan'] ?? null,
            ])->save();

            $updated++;
          } else {
            $this->skippedDupes++;
          }
          continue;
        }
      }

      Perangkat::create([
        'nama_perangkat'     => $nama,
        'nomor_inventaris' => $nomor,
        'tipe'               => $row['tipe'] ?? null,
        'spesifikasi'        => $row['spesifikasi'] ?? null,
        'deskripsi'          => $row['deskripsi'] ?? null,
        'perolehan'          => $row['perolehan'] ?? null,
        'tahun_pengadaan'    => $tahun,
        'catatan'            => $row['catatan'] ?? null,
        'mutasi'             => $row['mutasi'] ?? null,
        'upgrade'            => $row['upgrade'] ?? null,
        'kode'               => $kode,
        'lokasi_id'          => $lokasi_id,
        'jenis_id'           => $jenis_id_resolved ?? $jenis_id_x,
        'kondisi_id'         => $kondisi_id,
        'kategori_id'        => $kategori_id_resolved,

        // TAMBAH INI
        'tanggal_entry'      => $tanggalEntry,
        'merek_alat'         => $row['merek_alat'] ?? null,
        'nomor_seri'         => $row['nomor_seri'] ?? null,
        'no_akl_akd'         => $row['no_akl_akd'] ?? null,
        'produk'             => $row['produk'] ?? null,
        'tanggal_pembelian'  => $tanggalPembelian,
        'sumber_pendanaan'   => $row['sumber_pendanaan'] ?? null,
        'harga_beli_non_ppn' => $hargaNonPpn,
        'harga_beli_ppn'     => $hargaPpn,
        'keterangan'         => $row['keterangan'] ?? null,
      ]);
      $inserted++;
    }

    $msg = "Insert: {$inserted}, Update: {$updated}";
    if ($this->skippedNoName > 0 || $this->skippedDupes > 0) {
      $msg .= " | Skip(nama kosong): {$this->skippedNoName}, Skip(duplikat tanpa overwrite): {$this->skippedDupes}";
    }
    $msg .= ". NI yang kosong akan digenerate otomatis.";

    Notification::make()->title('Import selesai')->body($msg)->success()->send();

    $this->data = [
      'file'      => null,
      'policy'    => 'skip',
      'selective' => [],
    ];
    $this->dupes = [];
    $this->totalRows = 0;
    // $this->selective = [];
    $this->scanToken = null;
    $this->form->fill($this->data);
  }


  public function normalizeRowKeys(array $row): array
  {
    $out = [];
    foreach ($row as $k => $v) {
      $key = strtolower(trim((string) $k));
      $key = preg_replace('/\xc2\xa0/', ' ', $key);
      $key = str_replace('/', '_', $key);
      $key = preg_replace('/[.\s-]+/u', '_', $key);
      $key = trim($key, '_');

      $aliases = [
        // lama
        'no_inventaris'   => 'nomor_inventaris',
        'nomor_asset'     => 'nomor_inventaris',
        'no_asset'        => 'nomor_inventaris',
        'asset_number'    => 'nomor_inventaris',
        'tahun'           => 'tahun_pengadaan',
        'thn_pengadaan'   => 'tahun_pengadaan',
        'tgl_distribusi'  => 'tanggal_distribusi',
        'tanggal_distrib' => 'tanggal_distribusi',
        'lokasi_barang'   => 'lokasi',
        'jenis_barang'    => 'jenis',
        'status_barang'   => 'status',
        'kondisi_barang'  => 'kondisi',

        // header file Alkes
        'tanggal_entry'        => 'tanggal_entry',
        'nomor_inventaris'     => 'nomor_inventaris',
        'jenis_alat'           => 'jenis',
        'nama_alat'            => 'nama_perangkat',
        'merek_alat'           => 'merek_alat',
        'tipe_alat'            => 'tipe',
        'nomor_seri'           => 'nomor_seri',
        'kondisi_alat'         => 'kondisi',
        'distributor'          => 'distributor',
        'supplier'             => 'supplier',
        'no_akl_akd'           => 'no_akl_akd',
        'produk'               => 'produk',
        'tanggal_pembelian'    => 'tanggal_pembelian',
        'sumber_pendanaan'     => 'sumber_pendanaan',
        'harga_beli_non_ppn'   => 'harga_beli_non_ppn',
        'harga_beli_ppn'       => 'harga_beli_ppn',
        'lokasi'               => 'lokasi',
        'kategori_alat'        => 'kategori',
        'kode_kategori'        => 'kode_kategori',
        'keterangan'           => 'keterangan',
      ];

      $key = $aliases[$key] ?? $key;
      $out[$key] = $v;
    }
    return $out;
  }

  public static function canAccess(): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('perangkat.import');
  }
  public static function shouldRegisterNavigation(): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('perangkat.import');
  }
  public static function canViewAny(): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('perangkat.import');
  }
  public static function canCreate(): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('perangkat.import');
  }
  public static function canEdit(Model $record): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('perangkat.import');
  }
  public static function canDelete(Model $record): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('perangkat.import');
  }
  public static function canDeleteAny(): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('perangkat.import');
  }
  public function mount(): void
  {
    $this->bootMasterMaps();
  }
}
