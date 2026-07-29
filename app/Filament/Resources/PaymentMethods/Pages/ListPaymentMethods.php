<?php

namespace App\Filament\Resources\PaymentMethod\Pages;

use App\Filament\Resources\PaymentMethodResource;
use App\Filament\Resources\PaymentMethods\PaymentMethodResource as PaymentMethodsPaymentMethodResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListPaymentMethods extends ListRecords
{
    protected static string $resource = PaymentMethodsPaymentMethodResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create Payment Method'),
        ];
    }
    
   
}