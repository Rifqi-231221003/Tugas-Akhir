<?php

namespace App\Filament\Resources\Exchanges\Tables;

use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ExchangesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('exc_code')
                    ->label('Exchange Code')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                
                // Gambar From Product (diperbaiki)
                ImageColumn::make('product1_image')
                    ->label('From Product')
                    ->circular()
                    ->width(50)
                    ->height(50)
                    ->defaultImageUrl(function ($record) {
                        $product = Product::where('product_name', $record->product1)->first();

                        if ($product && $product->img && file_exists(public_path('img/product/' . $product->img))) {
                            return asset('img/product/' . $product->img);
                        }

                        return 'https://ui-avatars.com/api/?background=0D8F81&color=fff&name=' . urlencode($record->product1);
                    })
                    ->tooltip(fn ($record) => $record->product1),
                
                // Gambar untuk To Product (diperbaiki)
                ImageColumn::make('product2_image')
                    ->label('To Product')
                    ->circular()
                    ->width(50)
                    ->height(50)
                    ->defaultImageUrl(function ($record) {
                        $product = Product::where('product_name', $record->product2)->first();

                        if ($product && $product->img && file_exists(public_path('img/product/' . $product->img))) {
                            return asset('img/product/' . $product->img);
                        }

                        return 'https://ui-avatars.com/api/?background=0D8F81&color=fff&name=' . urlencode($record->product2);
                    })
                    ->tooltip(fn ($record) => $record->product2),
                
                TextColumn::make('rate')
                    ->label('Rate')
                    ->money('USD')
                    ->color('success')
                    ->weight('bold'),
                
                TextColumn::make('fee_type')
                    ->label('Fee Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Percentage' => 'success',
                        'Fiat' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => $state === 'Percentage' ? 'Percentage (%)' : 'Fiat ($)'),
                
                TextColumn::make('fee')
                    ->label('Fee')
                    ->formatStateUsing(function ($record) {
                        if ($record->fee_type === 'Percentage') {
                            return $record->fee . ' %';
                        }
                        return '$' . number_format($record->fee, 2);
                    })
                    ->badge()
                    ->color(fn ($record) => $record->fee_type === 'Percentage' ? 'warning' : 'info'),
                
                TextColumn::make('min')
                    ->label('Min Amount')
                    ->money('USD')
                    ->sortable()
                    ->color('danger')
                    ->weight('medium'),
            ])
            ->filters([
                SelectFilter::make('fee_type')
                    ->label('Fee Type')
                    ->options([
                        'Percentage' => 'Percentage (%)',
                        'Fiat' => 'Fiat ($)',
                    ])
                    ->placeholder('All Types'),
            ])
            ->recordActions([
                DeleteAction::make()
                    ->color('danger')
                    ->requiresConfirmation(),
            ])
            ->defaultSort('exc_code', 'desc')
            ->emptyStateHeading('No Exchange Rates Found')
            ->emptyStateDescription('Create your first exchange rate to get started.')
            ->emptyStateIcon('heroicon-o-arrow-path-rounded-square');
    }
}