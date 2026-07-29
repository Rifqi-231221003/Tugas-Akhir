<?php

namespace App\Filament\Resources\Exchanges\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ExchangeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product1')
                    ->label('From Product')
                    ->options(Product::all()->pluck('product_name', 'product_name'))
                    ->required()
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, callable $get) {
                        self::generateExchangeCode($set, $get);
                    })
                    ->validationAttribute('from product'),
                
                Select::make('product2')
                    ->label('To Product')
                    ->options(Product::all()->pluck('product_name', 'product_name'))
                    ->required()
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, callable $get) {
                        self::generateExchangeCode($set, $get);
                    })
                    ->validationAttribute('to product'),
                
                TextInput::make('exc_code')
                    ->label('Exchange Code')
                    ->required() 
                    ->disabled()
                    ->dehydrated(true)
                    ->helperText('Auto-generated from product code (SKRL-NTLR)'),
                
                TextInput::make('rate')
                    ->label('Exchange Rate')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->minValue(0)
                    ->rule('regex:/^\d+(\.\d{1,2})?$/')
                    ->helperText('Exchange rate in USD (max 2 decimal places)'),

                Select::make('fee_type')
                    ->label('Fee Type')
                    ->required()
                    ->options([
                        'Percentage' => 'Percentage (%)',
                        'Fiat' => 'Fiat ($)',
                    ])
                    ->native(false)
                    ->placeholder('Select Fee Type')
                    ->reactive()
                    ->default('Percentage'),
                
                TextInput::make('fee')
                    ->label('Fee')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->rule('regex:/^\d+(\.\d{1,2})?$/')
                    ->suffix(function (callable $get) {
                        $feeType = $get('fee_type');
                        return $feeType === 'Percentage' ? '%' : '$';
                    })
                    ->helperText(function (callable $get) {
                        $feeType = $get('fee_type');
                        return $feeType === 'Percentage' 
                            ? 'Fee in percentage (%) max 2 decimal places' 
                            : 'Fee in USD (max 2 decimal places)';
                    }),
                
                TextInput::make('min')
                    ->label('Minimum Amount')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->minValue(0)
                    ->rule('regex:/^\d+(\.\d{1,2})?$/')
                    ->helperText('Minimum transaction amount in USD (max 2 decimal places)'),

          
            
            ]);
    }

    /**
     * Generate exchange code from product codes
     */
    protected static function generateExchangeCode(callable $set, callable $get): void
    {
        $product1 = $get('product1');
        $product2 = $get('product2');
        
        if ($product1 && $product2) {
            // Get product codes from database
            $productModel1 = Product::where('product_name', $product1)->first();
            $productModel2 = Product::where('product_name', $product2)->first();
            
            if ($productModel1 && $productModel2) {
                $code = $productModel1->product_code . '-' . $productModel2->product_code;
                $set('exc_code', $code);
            }
        }
    }
}