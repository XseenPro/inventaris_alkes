<?php

namespace App\Filament\Resources\Kalibrasis\Pages;

use App\Filament\Resources\Kalibrasis\KalibrasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Filament\Actions\Action;

class ListKalibrasis extends ListRecords
{
    protected static string $resource = KalibrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_excel')
            ->label('Download Excel')
            ->icon('heroicon-o-document-arrow-down')
            ->url(route('export.kalibrasi.all.excel'), shouldOpenInNewTab:true)
            ->color('success')
        ];
    }
}
