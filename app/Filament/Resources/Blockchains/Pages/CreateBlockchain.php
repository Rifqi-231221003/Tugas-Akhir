<?php

namespace App\Filament\Resources\Blockchain\Pages;

use App\Filament\Resources\BlockchainResource;
use App\Filament\Resources\Blockchains\BlockchainResource as BlockchainsBlockchainResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlockchain extends CreateRecord
{
    protected static string $resource = BlockchainsBlockchainResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Blockchain created successfully!';
    }
    
    
    
    protected function getCreateFormActionLabel(): string
    {
        return 'Create Blockchain';
    }
    
    protected function getCancelFormActionLabel(): string
    {
        return 'Cancel';
    }
}