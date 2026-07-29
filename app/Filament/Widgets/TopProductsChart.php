<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class TopProductsChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Top Product';  
    
    protected function getData(): array
    {
        $topProducts = Payment::select('product1', DB::raw('count(*) as total'))
            ->groupBy('product1')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        return [
            'datasets' => [
                [
                    'label' => 'Top Product',
                    'data' => $topProducts->pluck('total')->toArray(),
                    'backgroundColor' => [
                        '#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'
                    ],
                ],
            ],
            'labels' => $topProducts->pluck('product1')->toArray(),
        ];
    }
    
    protected function getType(): string
    {
        return 'doughnut';
    }
}