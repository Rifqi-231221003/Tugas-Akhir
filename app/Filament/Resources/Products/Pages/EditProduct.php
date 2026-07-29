<?php

namespace App\Filament\Resources\Product\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\Products\ProductResource as ProductsProductResource;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductsProductResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Product updated successfully!';
    }
    
   
    
    protected function getSaveFormActionLabel(): string
    {
        return 'Save Changes';
    }
    
    protected function getCancelFormActionLabel(): string
    {
        return 'Cancel';
    }
}