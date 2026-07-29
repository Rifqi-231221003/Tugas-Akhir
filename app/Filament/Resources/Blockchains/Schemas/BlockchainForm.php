<?php

namespace App\Filament\Resources\Blockchains\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlockchainForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_name')
                    ->label('Product')
                    ->options([
                        'USDT' => 'USDT',
                        'USDC' => 'USDC',
                    ])
                    ->required()
                    ->live() // Agar reactive terhadap perubahan
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        // Update blockchain_code ketika product_name berubah
                        $blockchain = $get('blockchain');
                        if ($blockchain) {
                            $blockchainCode = $state . '-' . $blockchain;
                            $set('blockchain_code', $blockchainCode);
                        }
                    }),

                Select::make('blockchain')
                    ->options([
                        'BEP20' => 'BEP20',
                        'Binance Pay ID' => 'Binance Pay ID',
                        'ERC20' => 'ERC20',
                        'SOL' => 'SOL',
                        'BEP' => 'BEP',
                        'TON' => 'TON',
                        'TRC20' => 'TRC20',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        // Update blockchain_code ketika blockchain berubah
                        $productName = $get('product_name');
                        if ($productName) {
                            $blockchainCode = $productName . '-' . $state;
                            $set('blockchain_code', $blockchainCode);
                        }
                        // Update nama file gambar berdasarkan blockchain yang dipilih
                        $set('blockchain_img', null); // Reset field image
                    }),

                TextInput::make('blockchain_code')
                    ->label('Blockchain Code')
                    ->required()
                    ->disabled() // Tidak bisa diedit
                    ->dehydrated() // Tetap dikirim saat submit
                    ->helperText('Auto-generated'),

                TextInput::make('blockchain_fee')
                    ->label('Blockchain Fee (USD)')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->minValue(0),

                FileUpload::make('blockchain_img')
                    ->label('Blockchain Image')
                    ->disk('public')
                    ->directory('img/blockchain')
                    ->image()
                    ->preserveFilenames()
                    ->dehydrateStateUsing(fn ($state) => basename($state))
                    ->imageEditor()
                    ->maxSize(2048)
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/jpg',
                    ]),
                ]);
    }
}