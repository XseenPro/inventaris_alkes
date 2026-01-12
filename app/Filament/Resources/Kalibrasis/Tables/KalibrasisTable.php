<?php

namespace App\Filament\Resources\Kalibrasis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Kalibrasi;

class KalibrasisTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('perangkats.nomor_inventaris')
          ->searchable()
          ->label('Nomor Inventaris'),
        TextColumn::make('perangkats.nama_perangkat')
          ->searchable()
          ->label('Nomor Perangkat'),
        TextColumn::make('nomor_sertifikat')
          ->searchable()
          ->label('Nomor Sertifikat'),
        TextColumn::make('lokasi.nama_lokasi')
          ->label('Ruangan')
          ->toggleable(),
        TextColumn::make('tanggal_pelaksanaan')
          ->label('Tanggal Pelaksanaan')
          ->date('d M Y')
          ->sortable(),
        TextColumn::make('tanggal_kalibrasi')
          ->label('Tanggal Kalibrasi')
          ->date('d M Y')
          ->sortable(),
        TextColumn::make('hasil_kalibrasi')
          ->label('Hasil'),
        TextColumn::make('keterangan')
          ->label('Keterangan')
      ])
      ->filters([
        //
      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
