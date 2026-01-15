<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\Status;
use App\Models\Jenis;
use App\Models\Kategori;
use App\Models\Kondisi;

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
                'role' => 'teknik',
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

        // 3. DATA STATUS
        $statuses = [
            ['nama_status' => 'Aktif'],
            ['nama_status' => 'Rusak'],
            ['nama_status' => 'Expired'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
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
        $this->call(PerangkatSeeder::class);
    }
}