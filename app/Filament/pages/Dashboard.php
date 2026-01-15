<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;
use BackedEnum;
use UnitEnum;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public function getWidgets(): array
    {
        $user = Auth::user();

        if ($user->role === 'user') {
            return [
                \App\Filament\Widgets\PerangkatStatsOverview::class,
                \App\Filament\Widgets\ResumePeminjamanWidget::class,
            ];
        }

        return [
            \App\Filament\Widgets\PerangkatStatsOverview::class,
            \App\Filament\Widgets\RecentMaintenances::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 12;
    }
}
