<?php

namespace App\Filament\Resources\Product\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\Products\ProductResource as ProductsProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductsProductResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Product created successfully!';
    }
    
    
    
    protected function getCreateFormActionLabel(): string
    {
        return 'Create Product';
    }
    
    protected function getCancelFormActionLabel(): string
    {
        return 'Cancel';
    }
}