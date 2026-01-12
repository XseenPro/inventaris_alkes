<?php

namespace App\Filament\Resources\RiwayatMaintenances\Pages;

use App\Filament\Resources\RiwayatMaintenances\RiwayatMaintenanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRiwayatMaintenance extends CreateRecord
{
    protected static string $resource = RiwayatMaintenanceResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
