<?php

namespace App\Filament\Resources\Peminjaman\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PeminjamanInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema->components([
      ViewEntry::make('header')
        ->view('infolists.peminjaman.header-modern')
        ->columnSpanFull(),

      Section::make('Ringkasan')
        ->description('Informasi inti peminjaman secara singkat.')
        ->columns([
          'default' => 1,
          'md' => 2,
        ])
        ->schema([
          TextEntry::make('pihak_kedua_nama')->label('Peminjam')->placeholder('-'),
          TextEntry::make('peminjam_email')->label('Email')->placeholder('-'),
          TextEntry::make('status')->label('Status')->badge()->placeholder('-'),
        ]),

      Section::make('Informasi Barang')
        ->description('Detail perangkat yang dipinjam.')
        ->columns([
          'default' => 1,
          'md' => 2,
        ])
        ->schema([
          TextEntry::make('nomor_inventaris')->label('No. Inventaris')->placeholder('-'),
          TextEntry::make('nama_barang')->label('Nama Barang')->placeholder('-'),
          TextEntry::make('merk')->label('Merk')->placeholder('-'),
          TextEntry::make('kondisi_terakhir')->label('Kondisi Terakhir')->placeholder('-'),
        ]),

      Section::make('Periode')
        ->description('Waktu peminjaman dan pengingat.')
        ->columns([
          'default' => 1,
          'md' => 2,
        ])
        ->schema([
          TextEntry::make('tanggal_mulai')->label('Mulai')->date()->placeholder('-'),
          TextEntry::make('tanggal_selesai')->label('Selesai')->date()->placeholder('-'),
          TextEntry::make('reminder_h3_sent_at')->label('Reminder H-3')->dateTime()->placeholder('-'),
        ]),

      Section::make('Catatan')
        ->columns(1)
        ->schema([
          TextEntry::make('alasan_pinjam')->label('Alasan Pinjam')->placeholder('-'),
          TextEntry::make('catatan')->label('Catatan')->placeholder('-'),
        ]),

      Section::make('Audit')
        ->description('Jejak persetujuan & perubahan data.')
        ->collapsed()
        ->columnSpan('full')
        ->columns([
          'default' => 1,
          'md' => 2,
        ])
        ->schema([
          TextEntry::make('requestedBy.name')
            ->label('Diminta oleh')
            ->icon('heroicon-m-user')
            ->placeholder('-'),

          TextEntry::make('approvedBy.name')
            ->label('Ditindaklanjuti oleh')
            ->icon('heroicon-m-check-badge')
            ->color('success')
            ->placeholder('-'),

          TextEntry::make('approved_at')
            ->label('Approved at')
            ->dateTime('d M Y, H:i')
            ->placeholder('-'),

          TextEntry::make('rejected_at')
            ->label('Rejected at')
            ->dateTime('d M Y, H:i')
            ->color('danger')
            ->placeholder('-'),

          TextEntry::make('created_at')
            ->label('Created at')
            ->dateTime('d M Y, H:i')
            ->placeholder('-'),

          TextEntry::make('updated_at')
            ->label('Updated at')
            ->dateTime('d M Y, H:i')
            ->placeholder('-'),
        ]),
    ]);
  }
}
