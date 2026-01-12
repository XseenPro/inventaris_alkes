<?php

namespace App\Filament\Resources\Jenis\Pages;

use App\Filament\Resources\Jenis\JenisResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJenis extends EditRecord
{
    protected static string $resource = JenisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
