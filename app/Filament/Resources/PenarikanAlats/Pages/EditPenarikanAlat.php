<?php

namespace App\Filament\Resources\PenarikanAlats\Pages;

use App\Filament\Resources\PenarikanAlats\PenarikanAlatResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use App\Models\Kondisi;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPenarikanAlat extends EditRecord
{
  protected static string $resource = PenarikanAlatResource::class;

  protected function getHeaderActions(): array
  {
    return [
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }
  protected function afterCreate(): void
    {
        // 1. Ambil Record
        $record = $this->getRecord();
        $perangkat = $record->perangkat;

        if (!$perangkat) return;

        $alasan = $record->alasan_penarikan ?? [];
        $newKondisiId = null;

        $alasanLower = array_map('strtolower', $alasan);

        
        if (in_array('tidak layak pakai', $alasanLower) || in_array('melebihi masa pakai', $alasanLower)) {
            
            $kondisi = Kondisi::firstOrCreate(
                ['nama_kondisi' => 'Sudah tidak digunakan'] 
            );
            
            $newKondisiId = $kondisi->id;
        } 
        // KASUS 2: Rusak -> Target: "Rusak"
        elseif (in_array('rusak', $alasanLower)) {
            
            // Kita cari 'Rusak'. Karena di DB Anda ada 'rusak' (kecil), 
            // MySQL biasanya case-insensitive (Rusak = rusak).
            // Tapi jika tidak ketemu, dia akan bikin 'Rusak' (Huruf Besar).
            $kondisi = Kondisi::firstOrCreate(
                ['nama_kondisi' => 'Rusak']
            );
            
            $newKondisiId = $kondisi->id;
        }

        // 3. Update Perangkat
        if ($newKondisiId) {
            $perangkat->kondisi_id = $newKondisiId;
            $perangkat->save();
        }
    }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
