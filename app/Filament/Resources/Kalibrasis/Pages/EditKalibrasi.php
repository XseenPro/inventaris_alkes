<?php

namespace App\Filament\Resources\Kalibrasis\Pages;

use App\Filament\Resources\Kalibrasis\KalibrasiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditKalibrasi extends EditRecord
{
    protected static string $resource = KalibrasiResource::class;

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
