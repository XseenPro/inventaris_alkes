<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\Jenis;
use App\Models\Kategori;
use App\Models\Kondisi;
use App\Models\Distributor;
use App\Models\Supplier;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
  use WithoutModelEvents;

  public function run(): void
  {
    // 1. DATA USER
    $users = [
      [
        'name' => 'Super Administrator',
        'email' => 'superadmin@example.com',
        'role' => 'super-admin',
        'jabatan' => 'Head of IT',
        'unit' => 'SIRS',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('123456'),
      ],
      [
        'name' => 'Azkal Super Admin',
        'email' => 'askalaskia19@gmail.com',
        'role' => 'super-admin',
        'jabatan' => 'Head of Application',
        'unit' => 'SIRS',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('123456'),
      ],
      [
        'name' => 'Admin Manager',
        'email' => 'admin@example.com',
        'role' => 'admin',
        'jabatan' => 'Supervisor',
        'unit' => 'Human Resources',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('123456'),
      ],
      [
        'name' => 'Azkal Admin',
        'email' => 'azkalazkiya940@gmail.com',
        'role' => 'admin',
        'jabatan' => 'Supervisor',
        'unit' => 'Human Resources',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('123456'),
      ],
      [
        'name' => 'Regular User',
        'email' => 'user@example.com',
        'role' => 'user',
        'jabatan' => 'Staff',
        'unit' => 'Operational',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('123456'),
      ],
      [
        'name' => 'Azkal User',
        'email' => 'midoria580@gmail.com',
        'role' => 'user',
        'jabatan' => 'Staff',
        'unit' => 'Operational',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('123456'),
      ],
      [
        'name' => 'Azkal Teknik',
        'email' => 'kodepresensi@gmail.com',
        'role' => 'teknisi',
        'jabatan' => 'The Suhu of Teknik',
        'unit' => 'Operational',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('123456'),
      ],
    ];

    foreach ($users as $user) {
      User::create($user);
    }

    // 2. DATA LOKASI
    $lokasis = [
      ['nama_lokasi' => 'Bangsal Rama'],
      ['nama_lokasi' => 'Bangsal Shinta'],
      ['nama_lokasi' => 'Bangsal Bima'],
      ['nama_lokasi' => 'UGD'],
      ['nama_lokasi' => 'Rawat Jalan'],
    ];

    foreach ($lokasis as $lokasi) {
      Lokasi::create($lokasi);
    }

    $jenis_perangkats = [
      [
        'nama_jenis' => 'Kesehatan',
        'prefix' => 'A',
        'kode_jenis' => '01'
      ],
      [
        'nama_jenis' => 'Hardware',
        'prefix' => 'B',
        'kode_jenis' => '02.4'
      ],
    ];

    foreach ($jenis_perangkats as $jenis) {
      Jenis::create($jenis);
    }

    // 5. DATA KATEGORI
    $kategoris = [
      ['nama_kategori' => 'EKG', 'kode_kategori' => '009'],
      ['nama_kategori' => 'Kursi Roda', 'kode_kategori' => '019'],
    ];

    foreach ($kategoris as $kategori) {
      Kategori::create($kategori);
    }

    // 6. DATA KONDISI
    $kondisis = [
      ['nama_kondisi' => 'Baik'],
      ['nama_kondisi' => 'Buruk'],
      ['nama_kondisi' => 'Baru'],
      ['nama_kondisi' => 'Sedang'],
    ];

    foreach ($kondisis as $kondisi) {
      Kondisi::create($kondisi);
    }

    // 7. Distributor
    $distributor = [
      [
        'nama_distributor' => 'PT. Karya Pratama',
        'keterangan' => 'Arcadia Daan Mogot, Jl. Daan Mogot Blok F1 No.8A-8B, RT.001/RW.003, Kec. Batuceper, Kota Tangerang, Banten 15122'
      ],
      [
        'nama_distributor' => 'PT. Bintang Sarana Medika',
        'keterangan' => 'Komplek Rukan Medikal E2, Pondok Kelapa, Duren Sawit, Jakarta Timur, DKI Jakarta'
      ],
    ];
    foreach ($distributor as $distributors) {
      Distributor::create($distributors);
    }

    // 8. Supplier
    $supplier = [
      [
        'nama_supplier' => 'PT. Tesena Inovindo',
        'keterangan' => 'Jl. H. Jusin No. 43 Susukan Ciracas Jakarta Timur'
      ],
      [
        'nama_supplier' => 'PT Draeger Medical Indonesia',
        'keterangan' => 'Menara Standard Chartered Lt.30 Jl. Prof. Dr. Satrio No.164. Jakarta'
      ],
    ];
    foreach ($supplier as $suppliers) {
      Supplier::create($suppliers);
    }
    $this->call(PerangkatSeeder::class);
  }
}
