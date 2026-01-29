<?php

namespace App\Filament\Resources\Mutasis\Pages;

use App\Filament\Resources\Mutasis\MutasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;

class ListMutasis extends ListRecords
{
    protected static string $resource = MutasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_excel')
            ->label('Download Resume PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->url(route('mutasi.resume.pdf'), shouldOpenInNewTab:true)
            ->color('danger')
        ];
    }
}
