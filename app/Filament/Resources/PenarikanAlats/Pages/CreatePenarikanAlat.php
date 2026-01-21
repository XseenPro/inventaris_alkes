<?php

namespace App\Filament\Resources\PenarikanAlats\Pages;

use App\Filament\Resources\PenarikanAlats\PenarikanAlatResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Kondisi;
use Illuminate\Support\Facades\Auth;


class CreatePenarikanAlat extends CreateRecord
{
  protected static string $resource = PenarikanAlatResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['user_id'] = $data['user_id'] ?? Auth::id();
    return $data;
  }

  protected function afterCreate(): void
    {
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
        elseif (in_array('rusak', $alasanLower)) {
            
            $kondisi = Kondisi::firstOrCreate(
                ['nama_kondisi' => 'Rusak']
            );
            
            $newKondisiId = $kondisi->id;
        }

        if ($newKondisiId) {
            $perangkat->kondisi_id = $newKondisiId;
            $perangkat->save();

            // Opsional: Kirim notifikasi agar user tahu sistem membuat kondisi baru/update
            // Notification::make()
            //     ->title('Kondisi Perangkat Diupdate')
            //     ->body("Perangkat kini berkondisi: " . $kondisi->nama_kondisi)
            //     ->success()
            //     ->send();
        }
    }

  protected function getRedirectUrl(): string
  {
    $record = $this->record;

    if ($record->tindak_lanjut_tipe === 'Pindahan') {

      \Filament\Notifications\Notification::make()
        ->title('Penarikan Alat Berhasil Disimpan')
        ->body('Sekarang, silakan catat mutasi untuk perangkat pengganti.')
        ->success()
        ->send();

      return \App\Filament\Resources\Mutasis\MutasiResource::getUrl('create');
    }

    return $this->getResource()::getUrl('index');
  }
}
