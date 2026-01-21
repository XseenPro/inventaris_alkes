<?php

namespace App\Filament\Resources\AlatKesehatans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action;
use App\Models\Perangkat;

class AlatKesehatansTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('id', 'desc')
      ->columns([
        TextColumn::make('nomor_inventaris')->searchable(),
        TextColumn::make('nama_perangkat')->label('Nama/Jenis')->searchable(),
        TextColumn::make('merek_alat')->searchable(),
        TextColumn::make('nomor_seri')->label('No Seri')->searchable(),
        TextColumn::make('lokasi.nama_lokasi')->label('Lokasi')->searchable()->sortable(),
        // TextColumn::make('jenis.nama_jenis')->label('Jenis'),
        TextColumn::make('tanggal_entry')->date('d M Y')->sortable(),

        TextColumn::make('tipe')->label('Tipe'),

        TextColumn::make('kondisi.nama_kondisi')->label('Kondisi')->sortable(),

        TextColumn::make('no_akl_akd')->label('AKL/AKD'),
        TextColumn::make('produk'),
      ])
      ->filters([
        // SelectFilter::make('lokasi_id')->relationship('lokasi', 'nama_lokasi')->label('Lokasi'),
        // SelectFilter::make('kategori_id')->relationship('kategori', 'nama_kategori')->label('Kategori'),
        // SelectFilter::make('kondisi_id')->relationship('kondisi', 'nama_kondisi')->label('Kondisi'),
        // Filter::make('punya_nomor_seri')
        //     ->label('Ada Nomor Seri')
        //     ->query(fn (Builder $q) => $q->whereNotNull('nomor_seri')->where('nomor_seri', '!=', '')),
      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
        Action::make('Cetak Stiker')
          ->icon('heroicon-o-printer')
          ->label('Stiker')
          ->url(
            fn(Perangkat $record): string =>
            route('cetak.satu.stiker', ['perangkat' => $record->id])
          )
          ->openUrlInNewTab(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
