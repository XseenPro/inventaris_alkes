<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User as AppUser;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserResource extends Resource
{
    protected static ?string $model = AppUser::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';


    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return UserForm::schema($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::table($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $auth = Auth::user();

        if (! $auth instanceof AppUser) {
            return $query->whereRaw('1 = 0');
        }

        $query->where('id', '!=', $auth->id);

        if ($auth->isSuperAdmin()) {
            return $query->whereIn('role', ['admin', 'user']);
        }

        if ($auth->isAdmin()) {
            return $query->where('role', 'user');
        }

        return $query->whereRaw('1 = 0');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canView(Model $record): bool
    {
        $auth = Auth::user();

        if (! $auth instanceof AppUser) return false;

        if ($auth->isSuperAdmin()) {
            return $auth->canDo('user.view');
        }

        if ($auth->canDo('user.view')) {
            if ($record->isSuperAdmin()) return false;
            return true;
        }

        return false;
    }

    public static function canCreate(): bool
    {
        $auth = Auth::user();
        return $auth instanceof AppUser && $auth->canDo('user.create');
    }

    public static function canEdit(Model $record): bool
    {
        $auth = Auth::user();

        if (! $auth instanceof AppUser) return false;
        if (! $auth->canDo('user.edit')) return false;

        if ($auth->isAdmin() && $record->isSuperAdmin()) return false;

        return true;
    }

    public static function canDelete(Model $record): bool
    {
        $auth = Auth::user();

        if (! $auth instanceof AppUser) return false;
        if ($auth->id === $record->id) return false;
        if (! $auth->canDo('user.delete')) return false;

        if ($auth->isAdmin() && $record->isSuperAdmin()) return false;

        return true;
    }

    public static function canDeleteAny(): bool
    {
        $auth = Auth::user();
        return $auth instanceof AppUser && $auth->canDo('user.delete');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $auth = Auth::user();
        return $auth instanceof AppUser && $auth->canDo('user.view');
    }
}
