<?php

namespace App\Filament\Resources\AlatKesehatans;

use App\Filament\Resources\AlatKesehatans\Pages\CreateAlatKesehatan;
use App\Filament\Resources\AlatKesehatans\Pages\EditAlatKesehatan;
use App\Filament\Resources\AlatKesehatans\Pages\ListAlatKesehatans;
use App\Filament\Resources\AlatKesehatans\Pages\ViewAlatKesehatan;
use App\Filament\Resources\AlatKesehatans\Schemas\AlatKesehatanForm;
use App\Filament\Resources\AlatKesehatans\Schemas\AlatKesehatanInfolist;
use App\Filament\Resources\AlatKesehatans\Tables\AlatKesehatansTable;
use App\Models\Perangkat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Database\Eloquent\Model;

class AlatKesehatanResource extends Resource
{
  protected static ?string $model = Perangkat::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-eye-dropper';
  protected static string|UnitEnum|null $navigationGroup = 'Inventaris Alat';

  protected static ?string $recordTitleAttribute = 'nama_perangkat';
  protected static ?string $modelLabel = 'Alat Kesehatan';
  protected static ?string $pluralModelLabel = 'Alat Kesehatan';

  public static function form(Schema $schema): Schema
  {
    return AlatKesehatanForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return AlatKesehatanInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return AlatKesehatansTable::configure($table);
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
      'index' => ListAlatKesehatans::route('/'),
      'create' => CreateAlatKesehatan::route('/create'),
      'view' => ViewAlatKesehatan::route('/{record}'),
      'edit' => EditAlatKesehatan::route('/{record}/edit'),
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
