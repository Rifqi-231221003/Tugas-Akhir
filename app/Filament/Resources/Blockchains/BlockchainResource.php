<?php

namespace App\Filament\Resources\Blockchains;

use App\Filament\Resources\Blockchain\Pages\CreateBlockchain as PagesCreateBlockchain;
use App\Filament\Resources\Blockchain\Pages\EditBlockchain as PagesEditBlockchain;
use App\Filament\Resources\Blockchain\Pages\ListBlockchains as PagesListBlockchains;
use App\Filament\Resources\Blockchains\Pages\CreateBlockchain;
use App\Filament\Resources\Blockchains\Pages\EditBlockchain;
use App\Filament\Resources\Blockchains\Pages\ListBlockchains;
use App\Filament\Resources\Blockchains\Schemas\BlockchainForm;
use App\Filament\Resources\Blockchains\Tables\BlockchainsTable;
use App\Models\Blockchain;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;


class BlockchainResource extends Resource
{
    protected static ?string $model = Blockchain::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Blockchain';

    public static function form(Schema $schema): Schema
    {
        return BlockchainForm::configure($schema);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Sembunyikan dari sidebar
    }

    public static function table(Table $table): Table
    {
        return BlockchainsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => PagesListBlockchains::route('/'),
            'create' => PagesCreateBlockchain::route('/create'),
            'edit' => PagesEditBlockchain::route('/{record}/edit'),
        ];
    }
}
