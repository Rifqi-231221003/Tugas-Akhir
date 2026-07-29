<?php

namespace App\Filament\Resources\Blockchain\Pages;

use App\Filament\Resources\BlockchainResource;
use App\Filament\Resources\Blockchains\BlockchainResource as BlockchainsBlockchainResource;
use Filament\Resources\Pages\EditRecord;

class EditBlockchain extends EditRecord
{
    protected static string $resource = BlockchainsBlockchainResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Blockchain updated successfully!';
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