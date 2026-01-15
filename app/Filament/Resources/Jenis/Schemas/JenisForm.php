<?php

namespace App\Filament\Resources\Jenis\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class JenisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_jenis')
                    ->label('Nama Jenis')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('prefix')
                    ->label('Prefix (1 huruf)')
                    ->default('A')
                    ->maxLength(1)
                    ->required(),

                TextInput::make('kode_jenis')
                    ->label('Kode Jenis (mis. 01)')
                    ->default('01')
                    ->required()
                    ->rule('regex:/^\d{2}(\.\d{1})?$/')
                    ->helperText('Format: 2 digit, opsional ".1 digit". Contoh: 01 atau 01.2')
                    ->columnSpan('full'),
            ]);
    }
}
