<?php

namespace App\Filament\Resources\Lokasis;

use App\Filament\Resources\Lokasis\Pages\CreateLokasi;
use App\Filament\Resources\Lokasis\Pages\EditLokasi;
use App\Filament\Resources\Lokasis\Pages\ListLokasis;
use App\Filament\Resources\Lokasis\Schemas\LokasiForm;
use App\Filament\Resources\Lokasis\Tables\LokasisTable;
use App\Models\Lokasi;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Database\Eloquent\Model;

class LokasiResource extends Resource
{
    protected static ?string $model = Lokasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?string $recordTitleAttribute = 'nama_lokasi';
    protected static ?string $modelLabel = 'Lokasi Alat';
  protected static ?string $pluralModelLabel = 'Lokasi Alat';

    public static function form(Schema $schema): Schema
    {
        return LokasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LokasisTable::configure($table);
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
            'index' => ListLokasis::route('/'),
            // 'create' => CreateLokasi::route('/create'),
            'edit' => EditLokasi::route('/{record}/edit'),
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
