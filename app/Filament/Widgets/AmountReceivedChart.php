<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class AmountReceivedChart extends ChartWidget
{
    protected static ?int $sort = 5;

    protected ?string $heading = 'Total Amount Sent'; 
    
    protected function getData(): array
    {
        // Ambil data amount received per product2 
        $amountReceived = Payment::select('product2', DB::raw('SUM(CAST(product2_amount AS DECIMAL(10,2))) as total_amount'))
            ->where('product2_amount', '>', 0)
            ->groupBy('product2')
            ->orderBy('total_amount', 'desc')
            ->get();
        
        $labels = [];
        $data = [];
        $backgroundColors = [];
        
        $colorPalette = [
            '#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', 
            '#06b6d4', '#ec4898', '#84cc16', '#f97316', '#6366f1'
        ];
        
        foreach ($amountReceived as $index => $item) {
            // Format label: "800 Payoneer"
            $labels[] = number_format($item->total_amount, 0) . ' ' . $item->product2;
            $data[] = (float) $item->total_amount;
            $backgroundColors[] = $colorPalette[$index % count($colorPalette)];
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Total Amount Sent',
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