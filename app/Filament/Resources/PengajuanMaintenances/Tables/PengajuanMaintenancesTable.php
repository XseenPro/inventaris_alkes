<?php

namespace App\Filament\Resources\PengajuanMaintenances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PengajuanMaintenancesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('perangkats.nomor_inventaris')
          ->searchable()
          ->label('Nomor Inventaris'),

        TextColumn::make('perangkats.nama_perangkat')
          ->label('Perangkat'),

        TextColumn::make('lokasi.nama_lokasi')
          ->label('Ruangan')
          ->toggleable(),
        TextColumn::make('keterangan')
          ->label('Keterangan')
          ->toggleable(),
        TextColumn::make('user.name')
          ->label('Ditambahkan Oleh')
          ->toggleable(),
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
