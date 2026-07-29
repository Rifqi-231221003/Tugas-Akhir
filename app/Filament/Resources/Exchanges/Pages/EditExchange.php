<?php

namespace App\Filament\Resources\ExchangeRate\Pages;

use App\Filament\Resources\ExchangeRateResource;
use App\Filament\Resources\Exchanges\ExchangeResource;
use Filament\Resources\Pages\EditRecord;

class EditExchangeRate extends EditRecord
{
    protected static string $resource = ExchangeResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Exchange Rate updated successfully!';
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