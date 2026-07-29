<?php


namespace App\Filament\Resources\Blockchains\Tables;


use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class BlockchainsTable

{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('blockchain_img')
                    ->label('')
                    ->circular()
                    ->width(50)
                    ->height(50)
                    ->defaultImageUrl(function ($record) {
                        if (
                            $record->blockchain_img &&
                            file_exists(public_path('img/blockchain/' . $record->blockchain_img))
                        ) {
                            return asset('img/blockchain/' . $record->blockchain_img);
                        }
                        return 'https://via.placeholder.com/50x50?text=No+Image';
                    }),
                TextColumn::make('blockchain_code')
                    ->label('Blockchain Code')
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                
                TextColumn::make('blockchain')
                    ->label('Blockchain Name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => ucwords($state))
                    ->weight('bold')
                    ->color('black'),
                TextColumn::make('blockchain_fee')
                    ->label('Blockchain Fee')
                    ->numeric()
                    ->money('USD')
                    ->color('success')
                    ->weight('bold'),
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