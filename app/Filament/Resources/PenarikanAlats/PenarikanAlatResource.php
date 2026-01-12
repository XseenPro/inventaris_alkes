<?php

namespace App\Filament\Resources\PenarikanAlats;

use App\Filament\Resources\PenarikanAlats\Pages\CreatePenarikanAlat;
use App\Filament\Resources\PenarikanAlats\Pages\EditPenarikanAlat;
use App\Filament\Resources\PenarikanAlats\Pages\ListPenarikanAlats;
use App\Filament\Resources\PenarikanAlats\Pages\ViewPenarikanAlat;
use App\Filament\Resources\PenarikanAlats\Schemas\PenarikanAlatForm;
use App\Filament\Resources\PenarikanAlats\Schemas\PenarikanAlatInfolist;
use App\Filament\Resources\PenarikanAlats\Tables\PenarikanAlatsTable;
use App\Models\PenarikanAlat;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Database\Eloquent\Model;

class PenarikanAlatResource extends Resource
{
  protected static ?string $model = PenarikanAlat::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-inbox-arrow-down';
  protected static string|UnitEnum|null $navigationGroup = 'Inventaris Alat';

  protected static ?string $recordTitleAttribute = 'nama_perangkat';

  public static function form(Schema $schema): Schema
  {
    return PenarikanAlatForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return PenarikanAlatInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return PenarikanAlatsTable::configure($table);
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
      'index' => ListPenarikanAlats::route('/'),
      'create' => CreatePenarikanAlat::route('/create'),
      'view' => ViewPenarikanAlat::route('/{record}'),
      'edit' => EditPenarikanAlat::route('/{record}/edit'),
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
