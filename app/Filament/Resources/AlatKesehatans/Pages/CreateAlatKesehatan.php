<?php

namespace App\Filament\Resources\AlatKesehatans\Pages;

use App\Filament\Resources\AlatKesehatans\AlatKesehatanResource;
use Filament\Resources\Pages\CreateRecord;
use App\Support\NomorInventarisGenerator;
use Filament\Notifications\Notification;

class CreateAlatKesehatan extends CreateRecord
{
  protected static string $resource = AlatKesehatanResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $jenisId = $data['jenis_id'] ?? null;
    $kategoriId = $data['kategori_id'] ?? null;
    $tahun = $data['tahun_pembelian'] ?? date('Y');

    if (!$jenisId || !$kategoriId) {
      Notification::make()
        ->title('Gagal Generate Nomor Inventaris')
        ->body('Kategori dan Jenis Perangkat harus diisi.')
        ->danger()
        ->send();

      $this->halt();
    }

    try {
      $data['nomor_inventaris'] = NomorInventarisGenerator::generate(
        (int) $jenisId,
        (int) $kategoriId,
        (int) $tahun
      );
    } catch (\Exception $e) {
      Notification::make()
        ->title('Error Generator')
        ->body($e->getMessage())
        ->danger()
        ->send();
      $this->halt();
    }

    return $data;
  }

  protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
