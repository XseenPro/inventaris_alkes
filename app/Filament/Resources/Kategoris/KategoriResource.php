<?php

namespace App\Filament\Resources\Kategoris;

use App\Filament\Resources\Kategoris\Pages\CreateKategori;
use App\Filament\Resources\Kategoris\Pages\EditKategori;
use App\Filament\Resources\Kategoris\Pages\ListKategoris;
use App\Filament\Resources\Kategoris\Schemas\KategoriForm;
use App\Filament\Resources\Kategoris\Tables\KategorisTable;
use App\Models\Kategori;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Database\Eloquent\Model;

class KategoriResource extends Resource
{
  protected static ?string $model = Kategori::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
  protected static string|UnitEnum|null $navigationGroup = 'Data Master';

  protected static ?string $recordTitleAttribute = 'nama_kategori';
  protected static ?string $modelLabel = 'Kategori Alat';
  protected static ?string $pluralModelLabel = 'Kategori Alat';

  public static function form(Schema $schema): Schema
  {
    return KategoriForm::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return KategorisTable::configure($table);
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
      'index' => ListKategoris::route('/'),
      // 'create' => CreateKategori::route('/create'),
      'edit' => EditKategori::route('/{record}/edit'),
    ];
  }
  public static function canAccess(): bool
  {
      $user = Auth::user();
      return $user instanceof AppUser && $user->canDo('kategori.manage');
  }

  public static function shouldRegisterNavigation(): bool
  {
      $user = Auth::user();
      return $user instanceof AppUser && $user->canDo('kategori.manage');
  }

  public static function canViewAny(): bool
  {
      $user = Auth::user();
      return $user instanceof AppUser && $user->canDo('kategori.manage');
  }

  public static function canCreate(): bool
  {
      $user = Auth::user();
      return $user instanceof AppUser && $user->canDo('kategori.manage');
  }

  public static function canEdit(Model $record): bool
  {
      $user = Auth::user();
      return $user instanceof AppUser && $user->canDo('kategori.manage');
  }

  public static function canDelete(Model $record): bool
  {
      $user = Auth::user();
      return $user instanceof AppUser && $user->canDo('kategori.manage');
  }
  public static function canDeleteAny(): bool
  {
      $user = Auth::user();
      return $user instanceof AppUser && $user->canDo('kategori.manage');
  }
}
