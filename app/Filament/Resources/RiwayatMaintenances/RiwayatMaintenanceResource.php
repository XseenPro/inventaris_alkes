<?php

namespace App\Filament\Resources\RiwayatMaintenances;

use App\Filament\Resources\RiwayatMaintenances\Pages\CreateRiwayatMaintenance;
use App\Filament\Resources\RiwayatMaintenances\Pages\EditRiwayatMaintenance;
use App\Filament\Resources\RiwayatMaintenances\Pages\ListRiwayatMaintenances;
use App\Filament\Resources\RiwayatMaintenances\Pages\ViewRiwayatMaintenance;
use App\Filament\Resources\RiwayatMaintenances\Schemas\RiwayatMaintenanceForm;
use App\Filament\Resources\RiwayatMaintenances\Schemas\RiwayatMaintenanceInfolist;
use App\Filament\Resources\RiwayatMaintenances\Tables\RiwayatMaintenancesTable;
use App\Models\RiwayatMaintenance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Database\Eloquent\Model;

class RiwayatMaintenanceResource extends Resource
{
  protected static ?string $model = RiwayatMaintenance::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';
  protected static string|UnitEnum|null $navigationGroup = 'Inventaris Alat';
  protected static ?string $modelLabel = 'Maintenance';
  protected static ?string $pluralModelLabel = 'Maintenance';

  public static function form(Schema $schema): Schema
  {
    return RiwayatMaintenanceForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return RiwayatMaintenanceInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return RiwayatMaintenancesTable::configure($table);
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
      'index' => ListRiwayatMaintenances::route('/'),
      'create' => CreateRiwayatMaintenance::route('/create'),
      'view' => ViewRiwayatMaintenance::route('/{record}'),
      'edit' => EditRiwayatMaintenance::route('/{record}/edit'),
    ];
  }

  public static function canAccess(): bool
    {
         $user = Auth::user();
        return $user instanceof AppUser && $user->canDo('perangkat.status.manage');
    }
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user instanceof AppUser && $user->canDo('perangkat.status.manage');
    }
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user instanceof AppUser && $user->canDo('perangkat.status.manage');
    }
    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user instanceof AppUser && $user->canDo('perangkat.status.manage');
    }
    public static function canEdit(Model $record): bool
    {
        $user = Auth::user();
        return $user instanceof AppUser && $user->canDo('perangkat.status.manage');
    }
    public static function canDelete(Model $record): bool
    {
        $user = Auth::user();
        return $user instanceof AppUser && $user->canDo('perangkat.status.manage');
    }
    public static function canDeleteAny(): bool
    {
        $user = Auth::user();
        return $user instanceof AppUser && $user->canDo('perangkat.status.manage');
    }
}
