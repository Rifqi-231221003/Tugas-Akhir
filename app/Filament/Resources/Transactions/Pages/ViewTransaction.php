<?php

namespace App\Filament\Resources\Transactions\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Fieldset;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
           
        ];
    }
}