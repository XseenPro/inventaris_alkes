<?php

namespace App\Filament\Resources\peminjaman\Pages;

use App\Filament\Resources\peminjaman\PeminjamanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class Listpeminjaman extends ListRecords
{
  protected static string $resource = PeminjamanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make(),
    ];
  }
}
