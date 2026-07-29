<?php

namespace App\Filament\Resources\User\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\Users\UserResource as UsersUserResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListUsers extends ListRecords
{
    protected static string $resource = UsersUserResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create User'),
        ];
    }
    
}