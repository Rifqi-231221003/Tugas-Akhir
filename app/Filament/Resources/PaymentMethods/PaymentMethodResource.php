<?php

namespace App\Filament\Resources\PaymentMethods;

use App\Filament\Resources\PaymentMethod\Pages\CreatePaymentMethod as PagesCreatePaymentMethod;
use App\Filament\Resources\PaymentMethod\Pages\EditPaymentMethod as PagesEditPaymentMethod;
use App\Filament\Resources\PaymentMethod\Pages\ListPaymentMethods as PagesListPaymentMethods;
use App\Filament\Resources\PaymentMethods\Pages\CreatePaymentMethod;
use App\Filament\Resources\PaymentMethods\Pages\EditPaymentMethod;
use App\Filament\Resources\PaymentMethods\Pages\ListPaymentMethods;
use App\Filament\Resources\PaymentMethods\Schemas\PaymentMethodForm;
use App\Filament\Resources\PaymentMethods\Tables\PaymentMethodsTable;
use App\Models\PaymentMethod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Payment Method';

    public static function form(Schema $schema): Schema
    {
        return PaymentMethodForm::configure($schema);
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Sembunyikan dari sidebar
    }

    public static function table(Table $table): Table
    {
        return PaymentMethodsTable::configure($table);
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
            'index' => PagesListPaymentMethods::route('/'),
            'create' => PagesCreatePaymentMethod::route('/create'),
            'edit' => PagesEditPaymentMethod::route('/{record}/edit'),
        ];
    }
}
