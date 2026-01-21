<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_supplier')
                ->label('Nama Supplier')
                ->required()
                ->columnSpanFull()
                ->maxLength(255),

              TextArea::make('keterangan')
              ->label('Keterangan')
              ->columnSpanFull(),
            ]);
    }
}
