<?php

namespace App\Filament\Resources\PaymentMethods\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentMethodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pm_code')
                    ->label('PM Code')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('product_name')
                    ->label('Product Name')
                    ->searchable()
                    ->weight('bold')
                    ->color('black'),
                TextColumn::make('pm_blockchain')
                    ->label('Blockchain')
                    ->searchable()
                    ->weight('bold')
                    ->color('black'),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Email' => 'success',
                        'Wallet' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('destination')
                    ->label('Destination')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->searchable()
                    ->weight('medium')
                    ->color('black'),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->weight('medium')
                    ->color('black'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make()
                    ->color('danger')
                    ->requiresConfirmation(),
            ]);
          
    }
}
