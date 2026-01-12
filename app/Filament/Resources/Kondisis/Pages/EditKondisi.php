<?php

namespace App\Filament\Resources\Kondisis\Pages;

use App\Filament\Resources\Kondisis\KondisiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKondisi extends EditRecord
{
    protected static string $resource = KondisiResource::class;

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
