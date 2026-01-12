<?php

namespace App\Filament\Resources\peminjaman\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PeminjamanInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextEntry::make('perangkat.id')
          ->label('Perangkat')
          ->placeholder('-'),
        TextEntry::make('nomor_inventaris')
          ->placeholder('-'),
        TextEntry::make('nama_barang'),
        TextEntry::make('merk')
          ->placeholder('-'),
        TextEntry::make('kondisi_terakhir')
          ->placeholder('-'),
        TextEntry::make('alasan_pinjam')
          ->placeholder('-')
          ->columnSpanFull(),
        TextEntry::make('tanggal_mulai')
          ->date()
          ->placeholder('-'),
        TextEntry::make('tanggal_selesai')
          ->date()
          ->placeholder('-'),
        TextEntry::make('status')
          ->badge(),
        TextEntry::make('catatan')
          ->placeholder('-')
          ->columnSpanFull(),
        TextEntry::make('reminder_h3_sent_at')
          ->dateTime()
          ->placeholder('-'),
        TextEntry::make('peminjam_email')
          ->placeholder('-'),
        TextEntry::make('requested_by_user_id')
          ->numeric()
          ->placeholder('-'),
        TextEntry::make('approved_by_user_id')
          ->numeric()
          ->placeholder('-'),
        TextEntry::make('approved_at')
          ->dateTime()
          ->placeholder('-'),
        TextEntry::make('rejected_at')
          ->dateTime()
          ->placeholder('-'),
        TextEntry::make('created_at')
          ->dateTime()
          ->placeholder('-'),
        TextEntry::make('updated_at')
          ->dateTime()
          ->placeholder('-'),
      ]);
  }
}
