<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTransactionsTable extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Pending Transactions';
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payment::query()
                    ->where('trx_status', 'Pending')
                    ->orderBy('trx_date', 'desc')
                    ->limit(10)
            )
            ->recordUrl(
                fn ($record): string => route('filament.admin.resources.transactions.index', 
                ['record' => $record])              // Menuju ke Halaman List Transaksi
            )
            ->columns([
                Tables\Columns\TextColumn::make('trx_date')
                    ->label('Date')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('trx_id')
                    ->label('Trx ID')
                    ->copyable()
                    ->copyMessage('Copied!'),
                
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Client Name'),
                
                Tables\Columns\TextColumn::make('product1')
                    ->label('From')
                    ->badge()
                    ->color('primary'),
                
                Tables\Columns\TextColumn::make('product2')
                    ->label('To')
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('product1_amount')
                    ->label('Amount')
                    ->formatStateUsing(fn ($record): string => number_format($record->product1_amount, 2) . ' ' . $record->product1),
                
                Tables\Columns\BadgeColumn::make('trx_status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Success',
                        'warning' => 'Pending',
                        'danger' => 'Rejected',
                    ])
                    ->icon(fn (string $state): string => match ($state) {
                        'Pending' => 'heroicon-o-clock',
                        'Success' => 'heroicon-o-check-circle',
                        'Rejected' => 'heroicon-o-x-circle',
                    }),
            ])
            ->emptyStateHeading('No pending transactions')
            ->emptyStateDescription('All transactions have been processed');
    }
}