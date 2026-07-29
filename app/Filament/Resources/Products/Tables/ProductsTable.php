<?php

namespace App\Filament\Resources\Product\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               ImageColumn::make('img')
                    ->label('')
                    ->circular()
                    ->width(50)
                    ->height(50)
                    ->defaultImageUrl(function ($record) {
                        if (
                            $record->img &&
                            file_exists(public_path('img/product/' . $record->img))
                        ) {
                            return asset('img/product/' . $record->img);
                        }
                        return 'https://via.placeholder.com/50x50?text=No+Image';
                    }),
                TextColumn::make('product_code')
                    ->label('Product Code')
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                
               TextColumn::make('product_name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => ucwords($state))
                    ->weight('bold')
                    ->color('black'),
                
                TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'E-Money' => 'success',
                        'Crypto' => 'warning',
                        default => 'gray',
                    })
                    ->searchable(),
                
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Deactive' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->recordActions([
                DeleteAction::make(),
            ]);
    }
}