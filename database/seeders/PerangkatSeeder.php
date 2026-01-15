<?php

namespace Database\Seeders;

use App\Models\Perangkat;
use App\Models\User;
use App\Models\Lokasi;
use App\Models\Status;
use App\Models\Jenis;
use App\Models\Kategori;
use App\Models\Kondisi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PerangkatSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super-admin')->first();

        $bangsalRama   = Lokasi::where('nama_lokasi', 'Bangsal Rama')->first();
        $bangsalShinta = Lokasi::where('nama_lokasi', 'Bangsal Shinta')->first();
        $ugd           = Lokasi::where('nama_lokasi', 'UGD')->first();

        $statusAktif = Status::where('nama_status', 'Aktif')->first();
        $statusRusak = Status::where('nama_status', 'Rusak')->first();

        $jenisKesehatan = Jenis::where('nama_jenis', 'Kesehatan')->first();
        $kategoriEKG    = Kategori::where('nama_kategori', 'EKG')->first();
        $kategoriKursi  = Kategori::where('nama_kategori', 'Kursi Roda')->first();

        $kondisiBaik  = Kondisi::where('nama_kondisi', 'Baik')->first();
        $kondisiBuruk = Kondisi::where('nama_kondisi', 'Buruk')->first();

        $now = Carbon::now('Asia/Jakarta');

        $items = [
            [
                'lokasi_id'          => $bangsalRama?->id,
                'kategori_id'        => $kategoriEKG?->id,
                'jenis_id'           => $jenisKesehatan?->id,
                'kondisi_id'         => $kondisiBaik?->id,
                'status_id'          => $statusAktif?->id,
                'bulan'              => $now->format('F'),
                'tanggal_entry'      => $now->toDateString(),
                'nomor_inventaris'   => 'A.01.001.01.2026',
                'nama_perangkat'     => 'Electrocardiograph 3 Channel',
                'merek_alat'         => 'Philips',
                'jumlah_alat'        => 1,
                'tipe'               => 'PageWriter TC30',
                'nomor_seri'         => 'EKG-2026-0001',
                'distributor'        => 'PT Medika Sejahtera',
                'supplier'           => 'PT Medika Sejahtera',
                'no_akl_akd'         => 'AKL 20123456789',
                'produk'             => 'Alat Elektrokardiograf',
                'tanggal_pembelian'  => '2026-01-05',
                'tahun_pembelian'    => 2026,
                'sumber_pendanaan'   => 'APBD',
                'harga_beli_ppn'     => 350000000,
                'harga_beli_non_ppn' => 320000000,
                'keterangan'         => 'Digunakan untuk monitoring EKG pasien di Bangsal Rama.',
                'created_by'         => $admin?->id,
                'updated_by'         => $admin?->id,
                'created_at'         => $now,
                'updated_at'         => $now,
            ],
            [
                'lokasi_id'          => $bangsalShinta?->id,
                'kategori_id'        => $kategoriKursi?->id,
                'jenis_id'           => $jenisKesehatan?->id,
                'kondisi_id'         => $kondisiBaik?->id,
                'status_id'          => $statusAktif?->id,
                'bulan'              => $now->format('F'),
                'tanggal_entry'      => $now->toDateString(),
                'nomor_inventaris'   => 'A.01.019.02.2025',
                'nama_perangkat'     => 'Kursi Roda Standar',
                'merek_alat'         => 'Saki',
                'jumlah_alat'        => 5,
                'tipe'               => 'Foldable Steel',
                'nomor_seri'         => 'KR-2025-0001',
                'distributor'        => 'PT Karya Medika',
                'supplier'           => 'PT Karya Medika',
                'no_akl_akd'         => null,
                'produk'             => 'Kursi Roda Pasien',
                'tanggal_pembelian'  => '2025-11-20',
                'tahun_pembelian'    => 2025,
                'sumber_pendanaan'   => 'Donasi',
                'harga_beli_ppn'     => 25000000,
                'harga_beli_non_ppn' => 23000000,
                'keterangan'         => 'Digunakan untuk mobilisasi pasien rawat inap.',
                'created_by'         => $admin?->id,
                'updated_by'         => $admin?->id,
                'created_at'         => $now,
                'updated_at'         => $now,
            ],
            [
                'lokasi_id'          => $ugd?->id,
                'kategori_id'        => $kategoriEKG?->id,
                'jenis_id'           => $jenisKesehatan?->id,
                'kondisi_id'         => $kondisiBuruk?->id,
                'status_id'          => $statusRusak?->id,
                'bulan'              => $now->format('F'),
                'tanggal_entry'      => $now->toDateString(),
                'nomor_inventaris'   => 'A.01.009.03.2024',
                'nama_perangkat'     => 'Defibrillator Monitor',
                'merek_alat'         => 'Zoll',
                'jumlah_alat'        => 1,
                'tipe'               => 'R Series',
                'nomor_seri'         => 'DF-2024-0003',
                'distributor'        => 'PT Medika Prima',
                'supplier'           => 'PT Medika Prima',
                'no_akl_akd'         => 'AKD 2011223344',
                'produk'             => 'Defibrillator dengan Monitor',
                'tanggal_pembelian'  => '2024-06-10',
                'tahun_pembelian'    => 2024,
                'sumber_pendanaan'   => 'APBN',
                'harga_beli_ppn'     => 475000000,
                'harga_beli_non_ppn' => 450000000,
                'keterangan'         => 'Sedang dalam proses perbaikan, tidak boleh digunakan.',
                'created_by'         => $admin?->id,
                'updated_by'         => $admin?->id,
                'created_at'         => $now,
                'updated_at'         => $now,
            ],
        ];

        foreach ($items as $item) {
            Perangkat::create($item);
        }
    }
}
