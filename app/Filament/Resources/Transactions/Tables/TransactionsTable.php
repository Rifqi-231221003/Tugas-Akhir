<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trx_date')
                    ->label('Transaction Date')
                    ->dateTime()
                    ->sortable()
                    ->weight('medium')
                    ->color('black')
                    ->searchable(),
                
                TextColumn::make('trx_id')
                    ->label('Transaction ID')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->sortable()
                    ->weight('medium')
                    ->color('black')
                    ->searchable(),
                
                TextColumn::make('client_name')
                    ->label('Client Name')
                    ->description(fn ($record) => 'Email: ' . $record->client_email . ' | Phone: ' . $record->client_phonenumber)
                    ->sortable()
                    ->weight('medium')
                    ->color('black')
                    ->searchable(),
                    
                
                TextColumn::make('product1')
                    ->label('Exchange')
                    ->badge()
                    ->color('primary')
                    ->formatStateUsing(function ($record) {
                        return $record->product1 . ' (' . $record->product1_amount . ') → ' . $record->product2 . ' (' . $record->product2_amount . ')';
                    })
                    ->searchable(query: function ($query, $search) {
                        return $query->whereRaw("CONCAT(product1, ' (', product1_amount, ') → ', product2, ' (', product2_amount, ')') like ?", ["%{$search}%"]);
                    }),

                    TextColumn::make('fee')
                    ->label('Fee')
                    ->money('USD')
                    ->color('success')
                    ->weight('medium'),

                    TextColumn::make('product2_dest')
                    ->label('Pay To')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->weight('medium')
                    ->color('blue'),
                    
                SelectColumn::make('trx_status')
                    ->label('Status')
                    ->searchable()
                    ->options([
                        'Success' => 'Success',
                        'Pending' => 'Pending',
                        'Rejected' => 'Rejected',
                        ])
                    ->selectablePlaceholder(false),               
            ])
            ->filters([
                SelectFilter::make('trx_status')
                    ->label('Status')
                    ->options([
                        'Success' => '✅ Success',
                        'Pending' => '⏳ Pending',
                        'Rejected' => '❌ Rejected',
                    ])
                    ->placeholder('All Status'),
            ])
             ->recordActions([                 
                // Action untuk melihat bukti payment product 1
                Action::make('view_payment_proof')
                    ->label('View Payment Proof')
                    ->icon('heroicon-o-document')
                    ->url(fn ($record) => asset($record->product1_payment_proof))
                    ->openUrlInNewTab(),
                
                // Action untuk upload bukti transfer product 2
                Action::make('upload_payment_proof_product2')
                    ->label('Upload Transfer Proof')
                    ->icon('heroicon-o-cloud-arrow-up')
                    ->color('success')
                    ->modalHeading('Upload Payment Proof')
                    ->modalWidth('lg')
                    ->form([
                        FileUpload::make('product2_payment_proof')
                            ->label('Payment Proof')
                            ->image()
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
                            ->disk('public') 
                            ->directory('img/payment/fulfillment')
                            ->required(),
         
                    ])
                    ->action(function ($record, array $data) {
                        // Simpan file ke database
                        $record->update([
                            'product2_payment_proof' => $data['product2_payment_proof'],
                        ]);      
                    }),
                     DeleteAction::make()
            ]);
    }
}