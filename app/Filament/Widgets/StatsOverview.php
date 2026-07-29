<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Transaction', Payment::count()),
            
            Stat::make('Successfull', Payment::where('trx_status', 'Success')->count())
                ->icon('heroicon-o-check-circle'),
            
            Stat::make('Pending', Payment::where('trx_status', 'Pending')->count())
                ->icon('heroicon-o-clock'),

        ];
    }
    
    // Atur urutan widget (opsional)
    protected function getColumns(): int
    {
        return 3;
    }
}