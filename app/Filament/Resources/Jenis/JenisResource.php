<?php

namespace App\Filament\Resources\Jenis;

use App\Filament\Resources\Jenis\Pages\CreateJenis;
use App\Filament\Resources\Jenis\Pages\EditJenis;
use App\Filament\Resources\Jenis\Pages\ListJenis;
use App\Filament\Resources\Jenis\Schemas\JenisForm;
use App\Filament\Resources\Jenis\Tables\JenisTable;
use App\Models\Jenis;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Database\Eloquent\Model;

class JenisResource extends Resource
{
    protected static ?string $model = Jenis::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup = 'Data Master';
    protected static ?string $modelLabel = 'Jenis Alat';
  protected static ?string $pluralModelLabel = 'Jenis Alat';

    protected static ?string $recordTitleAttribute = 'nama_jenis';

    public static function form(Schema $schema): Schema
    {
        return JenisForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisTable::configure($table);
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
            'index' => ListJenis::route('/'),
            // 'create' => CreateJenis::route('/create'),
            'edit' => EditJenis::route('/{record}/edit'),
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
