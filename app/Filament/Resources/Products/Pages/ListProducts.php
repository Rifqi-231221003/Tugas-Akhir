<?php

namespace App\Filament\Resources\Product\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\Products\ProductResource as ProductsProductResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductsProductResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create Product'),
        ];
    }
    
    
}