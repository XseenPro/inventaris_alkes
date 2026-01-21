<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\User as AppUser;

class UserForm
{
  public static function schema(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('name')
          ->required()
          ->maxLength(255),

        TextInput::make('email')
          ->email()
          ->required()
          ->unique(ignoreRecord: true),

        TextInput::make('password')
          ->password()
          ->revealable()
          ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
          ->dehydrated(fn($state) => filled($state)),

        Select::make('role')
          ->label('Role')
          ->options(function () {
            $auth = Auth::user();
            if ($auth instanceof AppUser && $auth->isSuperAdmin()) {
              return [
                'super-admin' => 'Super Admin',
                'admin'       => 'Admin',
                'teknisi'        => 'Teknisi',
                'user'        => 'User',
              ];
            }
            return ['user' => 'User'];
          })
          ->default('user')
          ->required()
          ->live()
          ->afterStateUpdated(function ($state, callable $set) {
            if ($state === 'user') {
              $set('permissions', []);
            }
          })
          ->disabled(function (string $operation) {
            $auth = Auth::user();
            return $operation === 'edit'
              && !($auth instanceof AppUser && $auth->isSuperAdmin());
          }),

        CheckboxList::make('permissions')
          ->label('Hak Akses Khusus')
          ->helperText('Jika dikosongkan, user akan mengikuti default berdasarkan role.')
          ->options(function ($get) {
            $role = $get('role');

            $all = [
              'dashboard.view' => 'Lihat Dashboard',

              'user.view'   => 'Lihat user',
              'user.manage' => 'Kelola user (tambah, edit, hapus)',

              'resume.view'   => 'Lihat resume',

              'peminjaman.view'   => 'Lihat peminjaman',
              'peminjaman.create' => 'Ajukan peminjaman',
              'peminjaman.manage' => 'Kelola peminjaman (edit, hapus, acc)',

              'perangkat.view'   => 'Lihat perangkat',
              'perangkat.manage' => 'Kelola perangkat (tambah, edit, hapus)',

              'perangkat.import' => 'Import perangkat',
              'perangkat.mutasi' => 'Kelola mutasi perangkat',
              'perangkat.jenis.manage'    => 'Kelola master jenis',
              'perangkat.kondisi.manage'  => 'Kelola master kondisi',
              'perangkat.lokasi.manage'   => 'Kelola master lokasi',
              'perangkat.kategori.manage' => 'Kelola master kategori',

              'maintenance.view'   => 'Lihat maintenance',
              'maintenance.manage' => 'Kelola maintenance (tambah, edit, hapus)',

              'penarikan.view'   => 'Lihat penarikan alat',
              'penarikan.manage' => 'Kelola penarikan alat (tambah, edit, hapus)',
            ];

            if ($role === 'user') {
              return [
                'dashboard.view'   => $all['dashboard.view'],
                'peminjaman.view'  => $all['peminjaman.view'],
                'peminjaman.create' => $all['peminjaman.create'],
              ];
            }

            return $all;
          })
          ->columns(2)
          ->visible(function () {
            $auth = Auth::user();
            return $auth instanceof AppUser && $auth->isSuperAdmin();
          })
          ->columns(2)
          ->visible(function () {
            $auth = Auth::user();
            return $auth instanceof AppUser && $auth->isSuperAdmin();
          }),

      ]);
  }
}
