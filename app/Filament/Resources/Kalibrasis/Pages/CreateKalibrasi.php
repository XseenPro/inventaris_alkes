<?php

namespace App\Filament\Resources\Kalibrasis\Pages;

use App\Filament\Resources\Kalibrasis\KalibrasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKalibrasi extends CreateRecord
{
    protected static string $resource = KalibrasiResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
