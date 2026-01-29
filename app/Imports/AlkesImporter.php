<?php

namespace App\Imports;

use App\Models\Perangkat;
use App\Models\Lokasi;
use App\Models\Kategori;
use App\Models\Jenis;
use App\Models\Kondisi;
use App\Models\Distributor;
use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class AlkesImporter implements ToCollection, WithStartRow
{
    protected array $lokasiMap = [];
    protected array $kategoriMap = [];
    protected array $jenisMap = [];
    protected array $kondisiMap = [];
    protected array $distributorMap = [];
    protected array $supplierMap = [];
    protected array $seenNomorSeri = [];

    public function __construct()
    {
        $this->bootMasterMaps();
    }

    protected function bootMasterMaps(): void
    {
        $this->lokasiMap = Lokasi::pluck('id', 'nama_lokasi')->toArray();
        $this->kategoriMap = Kategori::pluck('id', 'nama_kategori')->toArray();
        $this->jenisMap = Jenis::pluck('id', 'nama_jenis')->toArray();
        $this->kondisiMap = Kondisi::pluck('id', 'nama_kondisi')->toArray();
        $this->distributorMap = Distributor::pluck('id', 'nama_distributor')->toArray();
        $this->supplierMap = Supplier::pluck('id', 'nama_supplier')->toArray();
    }

    /**
     * Mulai dari baris ke-3 (skip baris 1: title, baris 2: header)
     */
    public function startRow(): int
    {
        return 3;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip jika nama alat kosong
            $namaAlat = $this->cleanString($row[4] ?? null);
            if (empty($namaAlat)) {
                continue;
            }

            // Mapping kolom Excel ke database
            // Index dimulai dari 0
            $data = [
                'no' => $row[0] ?? null,                          // A: No
                'tanggal_entry' => $row[1] ?? null,               // B: Tanggal Entry
                'nomor_inventaris' => $row[2] ?? null,            // C: Nomor Inventaris
                'jenis_alat' => $row[3] ?? null,                  // D: Jenis Alat
                'nama_alat' => $row[4] ?? null,                   // E: Nama Alat
                'merek_alat' => $row[5] ?? null,                  // F: Merek Alat
                'tipe_alat' => $row[6] ?? null,                   // G: Tipe Alat
                'nomor_seri' => $row[7] ?? null,                  // H: Nomor Seri
                'kondisi_alat' => $row[8] ?? null,                // I: Kondisi Alat
                'distributor' => $row[9] ?? null,                 // J: Distributor
                'supplier' => $row[10] ?? null,                   // K: Supplier
                'no_akl_akd' => $row[11] ?? null,                 // L: No AKL/AKD
                'produk' => $row[12] ?? null,                     // M: Produk
                'tanggal_pembelian' => $row[13] ?? null,          // N: Tanggal Pembelian
                'sumber_pendanaan' => $row[14] ?? null,           // O: Sumber Pendanaan
                'harga_beli_non_ppn' => $row[15] ?? null,         // P: Harga Beli Non PPN
                'harga_beli_ppn' => $row[16] ?? null,             // Q: Harga Beli PPN
                'lokasi' => $row[17] ?? null,                     // R: Lokasi
                'kategori_alat' => $row[18] ?? null,              // S: Kategori Alat
                'kode_kategori' => $row[19] ?? null,              // T: Kode Kategori
                'keterangan' => $row[20] ?? null,                 // U: Keterangan
            ];

            $this->processRow($data);
        }
    }

    protected function processRow(array $data): void
    {
        // Validasi nomor seri unik (skip duplikat)
        $nomorSeri = $this->cleanString($data['nomor_seri']);
        if (!empty($nomorSeri)) {
            if (isset($this->seenNomorSeri[$nomorSeri]) || 
                Perangkat::where('nomor_seri', $nomorSeri)->exists()) {
                return; // Skip duplikat
            }
            $this->seenNomorSeri[$nomorSeri] = true;
        } else {
            $nomorSeri = null; // Set null jika kosong
        }

        // Resolve foreign keys
        $lokasi_id = $this->getOrCreateId(
            $this->lokasiMap, 
            Lokasi::class, 
            'nama_lokasi', 
            $data['lokasi']
        );

        $kategori_id = $this->getOrCreateId(
            $this->kategoriMap, 
            Kategori::class, 
            'nama_kategori', 
            $data['kategori_alat'],
            ['kode_kategori' => $this->cleanString($data['kode_kategori'])]
        );

        $jenis_id = $this->getOrCreateId(
            $this->jenisMap, 
            Jenis::class, 
            'nama_jenis', 
            $data['jenis_alat']
        );

        $kondisi_id = $this->getOrCreateId(
            $this->kondisiMap, 
            Kondisi::class, 
            'nama_kondisi', 
            $data['kondisi_alat']
        );

        $distributor_id = $this->getOrCreateId(
            $this->distributorMap, 
            Distributor::class, 
            'nama_distributor', 
            $data['distributor'],
            ['keterangan' => '']
        );

        $supplier_id = $this->getOrCreateId(
            $this->supplierMap, 
            Supplier::class, 
            'nama_supplier', 
            $data['supplier'],
            ['keterangan' => '']
        );

        // Parse tanggal
        $tanggalEntry = $this->parseDate($data['tanggal_entry']);
        $tanggalPembelian = $this->parseDate($data['tanggal_pembelian']);

        // Parse harga (hapus karakter non-digit)
        $hargaNonPpn = $this->parsePrice($data['harga_beli_non_ppn']);
        $hargaPpn = $this->parsePrice($data['harga_beli_ppn']);

        // Insert ke database
        Perangkat::create([
            'lokasi_id' => $lokasi_id,
            'kategori_id' => $kategori_id,
            'jenis_id' => $jenis_id,
            'kondisi_id' => $kondisi_id,
            'tanggal_entry' => $tanggalEntry,
            'nomor_inventaris' => $this->cleanString($data['nomor_inventaris']),
            'nama_perangkat' => $this->cleanString($data['nama_alat']),
            'merek_alat' => $this->cleanString($data['merek_alat']),
            'tipe' => $this->cleanString($data['tipe_alat']),
            'nomor_seri' => $nomorSeri,
            'distributor_id' => $distributor_id,
            'supplier_id' => $supplier_id,
            'no_akl_akd' => $this->cleanString($data['no_akl_akd']),
            'produk' => $this->cleanString($data['produk']),
            'tanggal_pembelian' => $tanggalPembelian,
            'sumber_pendanaan' => $this->cleanString($data['sumber_pendanaan']),
            'harga_beli_ppn' => $hargaPpn,
            'harga_beli_non_ppn' => $hargaNonPpn,
            'keterangan' => $this->cleanString($data['keterangan']),
        ]);
    }

    /**
     * Get or create foreign key ID
     */
    protected function getOrCreateId(
        array &$map, 
        string $modelClass, 
        string $columnName, 
        ?string $value,
        array $additionalData = []
    ): ?int {
        $cleanValue = $this->cleanString($value);
        
        if (empty($cleanValue)) {
            return null;
        }

        // Check in memory map
        if (isset($map[$cleanValue])) {
            return $map[$cleanValue];
        }

        // Check in database
        $existing = $modelClass::where($columnName, $cleanValue)->first();
        if ($existing) {
            $map[$cleanValue] = $existing->id;
            return $existing->id;
        }

        // Create new
        $createData = array_merge([$columnName => $cleanValue], $additionalData);
        $created = $modelClass::create($createData);
        $map[$cleanValue] = $created->id;
        
        return $created->id;
    }

    /**
     * Parse tanggal dari berbagai format
     */
    protected function parseDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // Jika angka (Excel serial date)
        if (is_numeric($value)) {
            try {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Throwable $e) {
                return null;
            }
        }

        // Jika string tanggal
        $timestamp = strtotime((string)$value);
        return $timestamp ? date('Y-m-d', $timestamp) : null;
    }

    /**
     * Parse harga (hapus non-digit kecuali digit)
     */
    protected function parsePrice($value): ?int
    {
        if (empty($value)) {
            return null;
        }

        $cleaned = preg_replace('/[^0-9]/', '', (string)$value);
        return !empty($cleaned) ? (int)$cleaned : null;
    }

    /**
     * Clean string (trim dan handle null)
     */
    protected function cleanString($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $cleaned = trim((string)$value);
        return $cleaned !== '' ? $cleaned : null;
    }
}
