<?php

namespace App\Filament\Resources\AlatKesehatans\Pages;

use App\Filament\Resources\AlatKesehatans\AlatKesehatanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAlatKesehatan extends EditRecord
{
    protected static string $resource = AlatKesehatanResource::class;

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
