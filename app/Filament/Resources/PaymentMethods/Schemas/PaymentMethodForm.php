<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;

class PaymentMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_name')
                    ->label('Product')
                    ->required()
                    ->options([
                        'AirTM' => 'AirTM',
                        'Neteller' => 'Neteller',
                        'Payoneer' => 'Payoneer',                            
                        'PayPal' => 'Paypal',
                        'Skrill' => 'Skrill',
                        'USDC' => 'USDC',
                        'USDT' => 'USDT',
                    ])
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, Get $get) {
                        $set('pm_code', null);
                        $set('pm_blockchain', null);
                        static::updatePaymentMethodCode($set, $get);
                    }),
                
                Select::make('type')
                    ->label('Type')
                    ->options([
                        'Wallet' => 'Wallet',
                        'Email' => 'Email',
                        'Number' => 'Number',
                    ])
                    ->required()
                    ->reactive()
                    ->searchable()
                    ->afterStateUpdated(function (callable $set, Get $get) {
                        $set('pm_code', null);
                        static::updatePaymentMethodCode($set, $get);
                    }),
                
                // Blockchain Select - hanya muncul untuk USDC dan USDT
                Select::make('pm_blockchain')
                    ->label('Blockchain Network')
                    ->options([
                        'BEP20' => 'BEP20',
                        'ERC20' => 'ERC20',
                        'TRC20' => 'TRC20',
                        'SOL' => 'Solana',
                        'BTC' => 'BTC',
                        'Binance Pay ID' => 'Binance Pay ID',
                        'TON' => 'TON',
                    ])
                    ->required(fn (Get $get) => in_array($get('product_name'), ['USDC', 'USDT']))
                    ->reactive()
                    ->visible(fn (Get $get) => in_array($get('product_name'), ['USDC', 'USDT']))
                    ->afterStateUpdated(function (callable $set, Get $get) {
                        $set('pm_code', null);
                        static::updatePaymentMethodCode($set, $get);
                    }),
                
                TextInput::make('destination')
                    ->label('Enter wallet address, email, or phone number')
                    ->required(),
                
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->reactive(),
                
                TextInput::make('pm_code')
                    ->label('Payment Method Code')
                    ->disabled()
                    ->dehydrated()
                    ->afterStateHydrated(function (callable $set, Get $get) {
                        static::updatePaymentMethodCode($set, $get);
                    }),
            ]);
    }

    protected static function updatePaymentMethodCode(callable $set, Get $get): void
    {
        $product = $get('product_name');
        $type = $get('type');
        $blockchain = $get('pm_blockchain');
        
        if (empty($product)) {
            $set('pm_code', null);
            return;
        }
        
        // Untuk USDC dan USDT yang memerlukan blockchain
        if (in_array($product, ['USDC', 'USDT'])) {
            if (!empty($blockchain)) {
                $set('pm_code', "{$product}-{$blockchain}");
            } else {
                $set('pm_code', null);
            }
            return;
        }
        
        // Untuk produk yang hanya menggunakan nama produk (email-based)
        $emailBasedProducts = ['ARTM', 'NTLR', 'PNR', 'PP', 'SKRL'];
        if (in_array($product, $emailBasedProducts) && $type === 'email') {
            $set('pm_code', $product);
            return;
        }
        
        // Untuk produk dengan type address/number
        if (!empty($type)) {
            $typeMap = [
                // 'Wallet' => 'WALLET',
                // 'Email' => 'EMAIL',
                // 'Number' => 'NUMBER',
            ];
            $typeCode = $typeMap[$type] ?? '';
            
            if (!empty($typeCode)) {
                $set('pm_code', "{$product}-{$typeCode}");
                return;
            }
        }
        
        $set('pm_code', $product);
    }
}