<?php

namespace App\Filament\Resources\Peminjaman;

use App\Filament\Resources\peminjaman\Pages\CreatePeminjaman;
use App\Filament\Resources\peminjaman\Pages\EditPeminjaman;
use App\Filament\Resources\peminjaman\Pages\Listpeminjaman;
use App\Filament\Resources\peminjaman\Pages\ViewPeminjaman;
use App\Filament\Resources\peminjaman\Schemas\PeminjamanForm;
use App\Filament\Resources\peminjaman\Schemas\PeminjamanInfolist;
use App\Filament\Resources\peminjaman\Tables\peminjamanTable;
use App\Models\Peminjaman;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Database\Eloquent\Model;

class PeminjamanResource extends Resource
{
  protected static ?string $model = Peminjaman::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-ticket';
  protected static string|UnitEnum|null $navigationGroup = 'Inventaris Alat';
  protected static ?string $modelLabel = 'Peminjaman';
  protected static ?string $pluralModelLabel = 'Peminjaman';

  public static function form(Schema $schema): Schema
  {
    return PeminjamanForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return PeminjamanInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return peminjamanTable::configure($table);
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
      'index' => Listpeminjaman::route('/'),
      'create' => CreatePeminjaman::route('/create'),
      'view' => ViewPeminjaman::route('/{record}'),
      'edit' => EditPeminjaman::route('/{record}/edit'),
    ];
  }
  public static function canAccess(): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('peminjaman.view');
  }
  public static function shouldRegisterNavigation(): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('peminjaman.view');
  }
  public static function canViewAny(): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('peminjaman.view');
  }
  public static function canCreate(): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('peminjaman.create');
  }
  public static function canEdit(Model $record): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('peminjaman.create');
  }
  public static function canDelete(Model $record): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('peminjaman.create');
  }
  public static function canDeleteAny(): bool
  {
    $user = Auth::user();
    return $user instanceof AppUser && $user->canDo('peminjaman.create');
  }
}
