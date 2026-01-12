<?php

namespace App\Filament\Resources\Kondisis;

use App\Filament\Resources\Kondisis\Pages\CreateKondisi;
use App\Filament\Resources\Kondisis\Pages\EditKondisi;
use App\Filament\Resources\Kondisis\Pages\ListKondisis;
use App\Filament\Resources\Kondisis\Schemas\KondisiForm;
use App\Filament\Resources\Kondisis\Tables\KondisisTable;
use App\Models\Kondisi;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Database\Eloquent\Model;

class KondisiResource extends Resource
{
    protected static ?string $model = Kondisi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup = 'Data Master';
    protected static ?string $modelLabel = 'Kondisi Alat';
  protected static ?string $pluralModelLabel = 'Kondisi Alat';

    protected static ?string $recordTitleAttribute = 'nama_kondisi';

    public static function form(Schema $schema): Schema
    {
        return KondisiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KondisisTable::configure($table);
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
            'index' => ListKondisis::route('/'),
            // 'create' => CreateKondisi::route('/create'),
            'edit' => EditKondisi::route('/{record}/edit'),
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
