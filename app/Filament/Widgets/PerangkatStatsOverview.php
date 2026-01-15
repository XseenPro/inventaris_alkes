<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Perangkat;
use Illuminate\Support\Facades\Auth;
use App\Models\User as AppUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class PerangkatStatsOverview extends BaseWidget
{
    protected ?string $heading = 'Ringkasan';
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 12;

    // ⬇⬇ PERBAIKI BARIS INI
    // protected static ?string $pollingInterval = null;
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return Cache::remember('stats.perangkat', 300, function () {
            $totalPerangkat   = Perangkat::count();
            $aktif            = Perangkat::whereHas('status', fn($q) => $q->where('nama_status', 'Aktif'))->count();
            $rusak            = Perangkat::whereHas('status', fn($q) => $q->where('nama_status', 'Rusak'))->count();
            $tidakDigunakan   = Perangkat::whereHas('status', fn($q) => $q->where('nama_status', 'Sudah tidak digunakan'))->count();

            return [
                Stat::make('Total Perangkat', number_format($totalPerangkat))
                    ->description('Semua perangkat terdaftar')
                    ->icon('heroicon-o-computer-desktop'),

                Stat::make('Perangkat Aktif', number_format($aktif))
                    ->description('Status = Aktif')
                    ->icon('heroicon-o-check-circle')
                    ->color('success'),

                Stat::make('Perangkat Rusak', number_format($rusak))
                    ->description('Status = Rusak')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->color('warning'),

                Stat::make('Tidak Digunakan', number_format($tidakDigunakan))
                    ->description('Status = Sudah tidak digunakan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger'),
            ];
        });
    }
}

