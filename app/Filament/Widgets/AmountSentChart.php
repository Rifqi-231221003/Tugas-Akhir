<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class AmountSentChart extends ChartWidget
{
    protected static ?int $sort = 5;

    protected ?string $heading = 'Total Amount Received';  
    
    protected function getData(): array
    {
        // Ambil data amount sent per product1 
        $amountSent = Payment::select('product1', DB::raw('SUM(CAST(product1_amount AS DECIMAL(10,2))) as total_amount'))
            ->where('product1_amount', '>', 0)
            ->groupBy('product1')
            ->orderBy('total_amount', 'desc')
            ->get();
        
        $labels = [];
        $data = [];
        $backgroundColors = [];
        
        $colorPalette = [
            '#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', 
            '#06b6d4', '#ec4898', '#84cc16', '#f97316', '#6366f1'
        ];
        
        foreach ($amountSent as $index => $item) {
            // Format label: "1000 Skrill"
            $labels[] = number_format($item->total_amount, 0) . ' ' . $item->product1;
            $data[] = (float) $item->total_amount;
            $backgroundColors[] = $colorPalette[$index % count($colorPalette)];
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Total Amount Received',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => $backgroundColors,
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }
    
    protected function getType(): string
    {
        return 'bar';
    }
    
    protected function getHeight(): string
    {
        return '400px';
    }
}