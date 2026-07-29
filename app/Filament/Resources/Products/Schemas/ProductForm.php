<?php

namespace App\Filament\Resources\Product\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use App\Models\Product;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('product_code')
                    ->label('Product Code')
                    ->required()
                    ->maxLength(5)
                    ->unique(Product::class, 'product_code', ignoreRecord: true)
                    ->helperText('Maximum 5 characters'),
                
                TextInput::make('product_name')
                    ->label('Product Name')
                    ->required()
                    ->maxLength(10)
                    ->helperText('Maximum 10 characters'),
                
                Select::make('category')
                    ->label('Category')
                    ->required()
                    ->options([
                        'E-Money' => 'E-Money',
                        'Crypto' => 'Crypto',
                    ])
                    ->native(false)
                    ->placeholder('Select category'),
                
                Select::make('status')
                    ->label('Status')
                    ->required()
                    ->options([
                        'Active' => 'Active',
                        'Deactive' => 'Deactive',])
                    ->native(false)
                    ->placeholder('Select status'),
                
                FileUpload::make('img')
                    ->label('Product Image')
                    ->disk('public')
                    ->directory('img/product')
                    ->image()
                    ->preserveFilenames()
                    ->dehydrateStateUsing(fn ($state) => basename($state))
                    ->imageEditor()
                    ->maxSize(2048)
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/jpg',
                    ])
            ]);
    }
}