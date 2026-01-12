<?php

namespace App\Filament\Resources\Kalibrasis\Pages;

use App\Filament\Resources\Kalibrasis\KalibrasiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewKalibrasi extends ViewRecord
{
    protected static string $resource = KalibrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
