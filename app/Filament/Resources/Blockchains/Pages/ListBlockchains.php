<?php

namespace App\Filament\Resources\Blockchain\Pages;

use App\Filament\Resources\BlockchainResource;
use App\Filament\Resources\Blockchains\BlockchainResource as BlockchainsBlockchainResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListBlockchains extends ListRecords
{
    protected static string $resource = BlockchainsBlockchainResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create Blockchain'),
        ];
    }
    
    
}