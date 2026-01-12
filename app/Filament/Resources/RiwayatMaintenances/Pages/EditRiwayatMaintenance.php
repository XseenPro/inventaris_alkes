<?php

namespace App\Filament\Resources\RiwayatMaintenances\Pages;

use App\Filament\Resources\RiwayatMaintenances\RiwayatMaintenanceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatMaintenance extends EditRecord
{
    protected static string $resource = RiwayatMaintenanceResource::class;

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
