<?php

namespace App\Filament\Resources\PengajuanMaintenances;

use App\Filament\Resources\PengajuanMaintenances\Pages\CreatePengajuanMaintenance;
use App\Filament\Resources\PengajuanMaintenances\Pages\EditPengajuanMaintenance;
use App\Filament\Resources\PengajuanMaintenances\Pages\ListPengajuanMaintenances;
use App\Filament\Resources\PengajuanMaintenances\Pages\ViewPengajuanMaintenance;
use App\Filament\Resources\PengajuanMaintenances\Schemas\PengajuanMaintenanceForm;
use App\Filament\Resources\PengajuanMaintenances\Schemas\PengajuanMaintenanceInfolist;
use App\Filament\Resources\PengajuanMaintenances\Tables\PengajuanMaintenancesTable;
use App\Models\PengajuanMaintenance;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengajuanMaintenanceResource extends Resource
{
  protected static ?string $model = PengajuanMaintenance::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';
  protected static string|UnitEnum|null $navigationGroup = 'Inventaris Alat';
  protected static ?string $modelLabel = 'Pengajuan Maintenance';
  protected static ?string $pluralModelLabel = 'Pengajuan Maintenance';

  public static function form(Schema $schema): Schema
  {
    return PengajuanMaintenanceForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return PengajuanMaintenanceInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return PengajuanMaintenancesTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => ListPengajuanMaintenances::route('/'),
      'create' => CreatePengajuanMaintenance::route('/create'),
      'view' => ViewPengajuanMaintenance::route('/{record}'),
      'edit' => EditPengajuanMaintenance::route('/{record}/edit'),
    ];
  }
}
