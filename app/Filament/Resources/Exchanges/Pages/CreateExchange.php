<?php

namespace App\Filament\Resources\ExchangeRate\Pages;

use App\Filament\Resources\ExchangeRateResource;
use App\Filament\Resources\Exchanges\ExchangeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExchangeRate extends CreateRecord
{
    protected static string $resource = ExchangeResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Exchange Rate created successfully!';
    }
    
   
    
    protected function getCreateFormActionLabel(): string
    {
        return 'Create Exchange Rate';
    }
    
    protected function getCancelFormActionLabel(): string
    {
        return 'Cancel';
    }
}