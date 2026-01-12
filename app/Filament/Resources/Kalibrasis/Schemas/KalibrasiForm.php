<?php

namespace App\Filament\Resources\Kalibrasis\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Set;
use Carbon\Carbon;

use App\Models\Perangkat;

class KalibrasiForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Select::make('perangkat_id')
          ->label('Perangkat (Kode INV)')
          ->relationship('perangkats', 'nomor_inventaris')
          ->required()
          ->preload()
          ->searchable()
          ->getSearchResultsUsing(function (string $query) {
            $q = Perangkat::query()
              ->select(['id', 'nomor_inventaris'])
              ->orderBy('nomor_inventaris');

            if (filled($query)) {
              $q->where('nomor_inventaris', 'like', "%{$query}%");
            }
            return $q->limit(50)->pluck('nomor_inventaris', 'id')->toArray();
          })
          ->getOptionLabelUsing(fn($value) => Perangkat::find($value)?->nama_perangkat)
          ->default(fn() => request()->query('perangkat_id'))
          ->disabled(fn() => request()->query('perangkat_id') !== null)
          ->dehydrated()
          ->live()
          ->reactive()
          ->afterStateUpdated(function ($state, $set) {
            if (blank($state)) {
              $set('lokasi_id', null);
              return;
            }

            $perangkat = Perangkat::select(['id', 'lokasi_id'])->find($state);
            if ($perangkat) {
              $set('lokasi_id', $perangkat->lokasi_id);
            }
          }),

        TextInput::make('nomor_sertifikat')
          ->label('Nomor Sertifikat')
          ->required(),

        Select::make('lokasi_id')
          ->label('Lokasi Ruangan')
          ->relationship('lokasi', 'nama_lokasi')
          ->searchable()
          ->preload()
          ->dehydrated(),

        DatePicker::make('tanggal_pelaksanaan')
          ->label('Tanggal Pelaksanaan')
          ->required(),
        DatePicker::make('tanggal_kalibrasi')
          ->label('Tanggal Kalibrasi')
          ->required()
          ->live() 
          ->afterStateUpdated(function ($state, $set) {
            if ($state) {
              $tanggalOtomatis = Carbon::parse($state)->addYear();

              $set('tanggal_kalibrasi_ulang', $tanggalOtomatis->toDateString());
            }
          }),

        DatePicker::make('tanggal_kalibrasi_ulang')
          ->label('Tanggal Kalibrasi Ulang')
          ->required(),

        TextInput::make('hasil_kalibrasi')
          ->label('Hasil')
          ->nullable(),

        TextInput::make('keterangan')
          ->label('Keterangan')
          ->nullable(),

        FileUpload::make('sertifikat_kalibrasi')
          ->label('Sertifikat Kalibrasi (pdf)')
          ->disk('public')
          ->acceptedFileTypes(['application/pdf'])
          ->openable()
          ->downloadable()
          ->columnSpanFull()
      ]);
  }
}
