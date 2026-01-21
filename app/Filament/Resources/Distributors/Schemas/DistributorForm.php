<?php

namespace App\Filament\Resources\Distributors\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class DistributorForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('nama_distributor')
          ->label('Nama Distributor')
          ->required()
          ->columnSpanFull()
          ->maxLength(255),

        TextArea::make('keterangan')
          ->label('Keterangan')
          ->columnSpanFull(),
      ]);
  }
}
