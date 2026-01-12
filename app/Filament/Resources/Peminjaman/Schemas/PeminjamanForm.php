<?php

namespace App\Filament\Resources\peminjaman\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Peminjaman;
use App\Models\Perangkat;


class PeminjamanForm
{
  public static function configure(Schema $schema): Schema
  {
    $user = Auth::user();
    return $schema
      ->components([
        Section::make('Pengajuan Ditolak')
          ->schema([
            ViewField::make('status_badge')
              ->label('Status')
              ->view('filament.forms.components.status-badge'),

            Placeholder::make('rejected_reason')
              ->label('Alasan ditolak')
              ->content(fn($record) => $record?->rejected_reason ?? '—'),

            Placeholder::make('rejected_at')
              ->label('Waktu penolakan')
              ->content(
                fn($record) =>
                $record?->rejected_at
                  ? $record->rejected_at->timezone('Asia/Jakarta')->format('d/m/Y H:i')
                  : '—'
              ),
          ])
          ->columns(2)
          ->visible(fn($record) => $record?->status === 'Ditolak')
          ->extraAttributes([
            'class' => 'border border-red-500/70 bg-red-50 dark:bg-red-900/20 rounded-xl p-4 shadow-sm',
          ]),
        Section::make('Data Pihak Pertama')
          ->schema([
            Placeholder::make('decision_by_name')
              ->label(fn($record) => ($record?->status === 'Ditolak') ? 'Ditolak oleh' : 'Disetujui oleh')
              ->content(function ($record) {
                return $record?->approvedBy?->name
                  ?? $record?->pihak_pertama_nama
                  ?? '—';
              }),

            Placeholder::make('decision_at_info')
              ->label(fn($record) => ($record?->status === 'Ditolak') ? 'Waktu penolakan' : 'Waktu persetujuan')
              ->content(function ($record) {
                if ($record?->status === 'Ditolak') {
                  return $record?->rejected_at
                    ? $record->rejected_at->timezone('Asia/Jakarta')->format('d/m/Y H:i')
                    : '—';
                }
                return $record?->approved_at
                  ? $record->approved_at->timezone('Asia/Jakarta')->format('d/m/Y H:i')
                  : '—';
              }),

            Placeholder::make('pihak_pertama_jabatan_info')
              ->label('Jabatan (penyetuju)')
              ->content(fn($record) => $record?->pihak_pertama_jabatan ?? '—'),

            Placeholder::make('pihak_pertama_unit_info')
              ->label('Unit (penyetuju)')
              ->content(fn($record) => $record?->pihak_pertama_unit ?? '—'),
          ])
          ->columns(3)
          ->visibleOn(['view', 'edit']),

        Section::make('Data Pihak Kedua')
          ->schema([
            TextInput::make('pihak_kedua_nama')
              ->disabled()
              ->dehydrated()
              ->default($user?->name),

            TextInput::make('pihak_kedua_jabatan')->nullable(),
            TextInput::make('pihak_kedua_unit')->nullable(),

            TextInput::make('peminjam_email')
              ->label('Email Peminjam')
              ->email()
              ->disabled()
              ->dehydrated()
              ->default($user?->email),
          ])
          ->columns(3)
          ->visible(fn() => in_array(Auth::user()?->role, ['admin', 'super-admin'], true)),


        Section::make('Data Barang')->schema([
          Select::make('perangkat_id')
            ->label('Perangkat (Nomor Inventaris)')
            ->searchable()
            ->required()
            ->getSearchResultsUsing(function (string $query) {
              return Perangkat::query()
                ->with(['kondisi'])
                ->select(['id', 'nomor_inventaris', 'nama_perangkat', 'tipe', 'kondisi_id'])
                ->when(trim($query) !== '', function ($q) use ($query) {
                  $q->where('nomor_inventaris', 'like', "%{$query}%")
                    ->orWhere('nama_perangkat', 'like', "%{$query}%")
                    ->orWhere('tipe', 'like', "%{$query}%");
                })
                ->orderBy('nomor_inventaris')
                ->limit(50)
                ->get()
                ->mapWithKeys(function ($p) {
                  $label = "{$p->nomor_inventaris} — {$p->nama_perangkat}"
                    . ($p->tipe ? " ({$p->tipe})" : '');
                  return [$p->id => $label];
                })->toArray();
            })
            ->getOptionLabelUsing(function ($value) {
              $p = Perangkat::find($value);
              return $p
                ? "{$p->nomor_inventaris} — {$p->nama_perangkat}" . ($p->tipe ? " ({$p->tipe})" : '')
                : null;
            })
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set) {
              $p = Perangkat::with('kondisi')->find($state);
              if ($p) {
                $set('nomor_inventaris',  $p->nomor_inventaris);
                $set('nama_barang',       $p->nama_perangkat);
                $set('merk',              $p->tipe);
                $set('kondisi_terakhir',  $p->kondisi?->nama_kondisi);
              } else {
                $set('nomor_inventaris', null);
                $set('nama_barang',      null);
                $set('merk',             null);
                $set('kondisi_terakhir', null);
              }
            })
            ->default(fn() => request()->query('perangkat_id'))
            ->rules(['required', 'exists:perangkats,id']),

          TextInput::make('nomor_inventaris')
            ->label('Nomor Inventaris')
            ->disabled()
            ->dehydrated(),

          TextInput::make('nama_barang')
            ->label('Nama barang')
            ->helperText('Terisi otomatis dari perangkat, boleh diubah.'),

          TextInput::make('merk')
            ->label('Merek / Tipe')
            ->helperText('Terisi otomatis dari perangkat.tipe'),

          TextInput::make('kondisi_terakhir')
            ->disabled()
            ->dehydrated()
            ->helperText('Terisi otomatis dari kondisi perangkat saat ini'),

          Placeholder::make('reminder_h3_sent_at')
            ->label('Reminder H-3')
            ->content(fn($record) => $record?->reminder_h3_sent_at
              ? $record->reminder_h3_sent_at->timezone('Asia/Jakarta')->format('d/m/Y H:i')
              : '-'),
        ])->columns(2),

        Section::make('Peminjaman')->schema([
          Textarea::make('alasan_pinjam')->rows(3),
          DatePicker::make('tanggal_mulai')->required()->displayFormat('d/m/Y')->locale('id'),
          DatePicker::make('tanggal_selesai')->required()->displayFormat('d/m/Y')->locale('id'),

          Select::make('status')
            ->options([
              'Menunggu' => 'Menunggu acc',
              'Dipinjam' => 'Dipinjam',
              'Dikembalikan' => 'Dikembalikan',
              'Terlambat' => 'Terlambat',
              'Ditolak' => 'Ditolak',
            ])
            ->default('Menunggu')
            ->visible(fn() => in_array(Auth::user()?->role, ['admin', 'super-admin'], true)),

          Textarea::make('catatan')->rows(3)->nullable(),
        ])->columns(2)
      ]);
  }
}
