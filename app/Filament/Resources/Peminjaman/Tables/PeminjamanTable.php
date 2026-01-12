<?php

namespace App\Filament\Resources\Peminjaman\Tables;

use App\Notifications\PeminjamanApproved;
use App\Notifications\PeminjamanRejected;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class peminjamanTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('nomor_inventaris')->label('No. Inv')->searchable(),
        TextColumn::make('nama_barang')->searchable(),
        TextColumn::make('pihak_kedua_nama')->label('Peminjam'),
        TextColumn::make('tanggal_mulai')->date('d/m/Y'),
        TextColumn::make('tanggal_selesai')->date('d/m/Y'),
        TextColumn::make('status')
          ->label('Status')
          ->badge()
          ->formatStateUsing(fn($state) => $state === 'Menunggu' ? 'Menunggu acc' : $state)
          ->color(fn(string $state): string => match ($state) {
            'Menunggu'     => 'gray',
            'Dipinjam'     => 'warning',
            'Dikembalikan' => 'success',
            'Terlambat'    => 'danger',
            'Ditolak'      => 'danger',
            default        => 'secondary',
          }),
      ])
      ->filters([
        //
      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
        Action::make('approve')
          ->label('Setujui')
          ->icon('heroicon-o-check')
          ->color('success')
          ->requiresConfirmation()
          ->visible(
            fn(Peminjaman $record) =>
            in_array(Auth::user()?->role, ['admin', 'super-admin'], true) && $record->status === 'Menunggu'
          )
          ->action(function (Peminjaman $record): void {
            $record->update([
              'status' => 'Dipinjam',
              'approved_by_user_id' => Auth::id(),
              'approved_at' => now('Asia/Jakarta'),
            ]);
            if ($record->peminjam_email) {
              Notification::route('mail', $record->peminjam_email)
                ->notify(new PeminjamanApproved($record));
            }
          }),

        Action::make('reject')
          ->label('Tolak')
          ->icon('heroicon-o-x-mark')
          ->color('danger')
          ->form([
            Textarea::make('reason')
              ->label('Alasan')
              ->rows(3)
          ])
          ->requiresConfirmation()
          ->visible(
            fn(Peminjaman $record) =>
            in_array(Auth::user()?->role, ['admin', 'super-admin'], true) && $record->status === 'Menunggu'
          )
          ->action(function (Peminjaman $record, array $data): void {
            $record->update([
              'status' => 'Ditolak',
              'approved_by_user_id' => Auth::id(),
              'rejected_at' => now('Asia/Jakarta'),
              'catatan' => trim(
                ($record->catatan ? $record->catatan . "/n" : '') . 'Ditolak: ' . ($data['reason'] ?? '-')
              )
            ]);
            if ($record->peminjam_email) {
              Notification::route('mail', $record->peminjam_email)
                ->notify(new PeminjamanRejected($record, $data['reason'] ?? null));
            }
          }),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
