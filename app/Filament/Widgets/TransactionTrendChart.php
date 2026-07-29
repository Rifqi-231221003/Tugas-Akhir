<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class TransactionTrendChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Transaction (Last 7 Days)';  
    
    protected function getData(): array
    {
        $trendLabels = [];
        $trendData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $trendLabels[] = $date->format('d M');
            $trendData[] = Payment::whereDate('trx_date', $date->toDateString())->count();
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Transaction',
                    'data' => $trendData,
                    'borderColor' => '#4f46e5',
                    'backgroundColor' => 'rgba(79, 70, 229, 0.1)',
                ],
            ],
            'labels' => $trendLabels,
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
}