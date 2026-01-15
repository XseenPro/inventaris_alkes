<?php

namespace App\Filament\Resources\PengajuanMaintenances\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use App\Models\Perangkat;
use Illuminate\Support\Facades\Auth;

class PengajuanMaintenanceForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
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
                $label = "{$p->nomor_inventaris}";
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
            if (blank($state)) {
              $set('lokasi_id', null);
              return;
            }

            $perangkat = Perangkat::select(['id', 'lokasi_id'])->find($state);
            if ($perangkat) {
              $set('lokasi_id', $perangkat->lokasi_id);
            }
          })
          ->default(fn() => request()->query('perangkat_id'))
          ->rules(['required', 'exists:perangkats,id']),

        TextInput::make('nama_barang')
          ->label('Nama barang')
          ->disabled()
          ->dehydrated(),
        TextInput::make('merk')
          ->label('Merek / Tipe')
          ->disabled()
          ->dehydrated(),

        Select::make('lokasi_id')
          ->label('Lokasi Ruangan')
          ->relationship('lokasi', 'nama_lokasi')
          ->searchable()
          ->preload()
          ->dehydrated(),

        TextArea::make('keterangan')
          ->label('Keterangan')
          ->maxLength(350)
          ->nullable()
          ->columnSpan('full')

      ]);
  }
}
