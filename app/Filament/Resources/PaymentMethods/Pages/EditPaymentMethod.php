<?php

namespace App\Filament\Resources\PaymentMethod\Pages;

use App\Filament\Resources\PaymentMethodResource;
use App\Filament\Resources\PaymentMethods\PaymentMethodResource as PaymentMethodsPaymentMethodResource;
use Filament\Resources\Pages\EditRecord;

class EditPaymentMethod extends EditRecord
{
    protected static string $resource = PaymentMethodsPaymentMethodResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Payment Method updated successfully!';
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