<?php

namespace App\Filament\Resources\Kalibrasis;

use App\Filament\Resources\Kalibrasis\Pages\CreateKalibrasi;
use App\Filament\Resources\Kalibrasis\Pages\EditKalibrasi;
use App\Filament\Resources\Kalibrasis\Pages\ListKalibrasis;
use App\Filament\Resources\Kalibrasis\Pages\ViewKalibrasi;
use App\Filament\Resources\Kalibrasis\Schemas\KalibrasiForm;
use App\Filament\Resources\Kalibrasis\Schemas\KalibrasiInfolist;
use App\Filament\Resources\Kalibrasis\Tables\KalibrasisTable;
use App\Models\Kalibrasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Database\Eloquent\Model;

class KalibrasiResource extends Resource
{
  protected static ?string $model = Kalibrasi::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-adjustments-vertical';

  protected static ?string $recordTitleAttribute = 'nomor_sertifikat';
  protected static string|UnitEnum|null $navigationGroup = 'Inventaris Alat';
  protected static ?string $modelLabel = 'Kalibrasi';
  protected static ?string $pluralModelLabel = 'Kalibrasi';

  public static function form(Schema $schema): Schema
  {
    return KalibrasiForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return KalibrasiInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return KalibrasisTable::configure($table);
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
      'index' => ListKalibrasis::route('/'),
      'create' => CreateKalibrasi::route('/create'),
      'view' => ViewKalibrasi::route('/{record}'),
      'edit' => EditKalibrasi::route('/{record}/edit'),
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
