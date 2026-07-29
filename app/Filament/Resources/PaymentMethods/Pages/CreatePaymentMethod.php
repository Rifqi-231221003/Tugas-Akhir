<?php

namespace App\Filament\Resources\PaymentMethod\Pages;

use App\Filament\Resources\PaymentMethodResource;
use App\Filament\Resources\PaymentMethods\PaymentMethodResource as PaymentMethodsPaymentMethodResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentMethod extends CreateRecord
{
    protected static string $resource = PaymentMethodsPaymentMethodResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Payment Method created successfully!';
    }
    
    
    
    protected function getCreateFormActionLabel(): string
    {
        return 'Create Payment Method';
    }
    
    protected function getCancelFormActionLabel(): string
    {
        return 'Cancel';
    }
}