<?php

namespace App\Filament\Resources\ExchangeRate\Pages;

use App\Filament\Resources\ExchangeRateResource;
use App\Filament\Resources\Exchanges\ExchangeResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListExchangeRates extends ListRecords
{
    protected static string $resource = ExchangeResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create Exchange Rate'),
        ];
    }
    
    
}