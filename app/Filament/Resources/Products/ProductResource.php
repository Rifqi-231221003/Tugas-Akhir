<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\Product\Pages;
use App\Filament\Resources\Product\Pages\CreateProduct as PagesCreateProduct;
use App\Filament\Resources\Product\Pages\EditProduct as PagesEditProduct;
use App\Filament\Resources\Product\Pages\ListProducts as PagesListProducts;
use App\Filament\Resources\Product\Schemas\ProductForm as SchemasProductForm;
use App\Filament\Resources\Product\Tables\ProductsTable as TablesProductsTable;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'product_name'; 

    public static function form(Schema $schema): Schema
    {
        return SchemasProductForm::configure($schema);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Sembunyikan dari sidebar
    }

    public static function table(Table $table): Table
    {
        return TablesProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => PagesListProducts::route('/'),
            'create' => PagesCreateProduct::route('/create'),
            'edit' => PagesEditProduct::route('/{record}/edit'),
        ];
    }
}