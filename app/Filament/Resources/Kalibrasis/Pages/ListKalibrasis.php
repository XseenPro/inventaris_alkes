<?php

namespace App\Filament\Resources\Kalibrasis\Pages;

use App\Filament\Resources\Kalibrasis\KalibrasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKalibrasis extends ListRecords
{
    protected static string $resource = KalibrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
