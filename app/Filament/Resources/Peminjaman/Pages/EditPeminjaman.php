<?php

namespace App\Filament\Resources\peminjaman\Pages;

use App\Filament\Resources\peminjaman\PeminjamanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPeminjaman extends EditRecord
{
  protected static string $resource = PeminjamanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }
  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
