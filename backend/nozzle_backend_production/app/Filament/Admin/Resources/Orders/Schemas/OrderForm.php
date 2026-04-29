<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('حالة الطلبية')
                    ->schema([
                        Select::make('status')
                            ->label('حالة الطلب')
                            ->options([
                                'pending' => 'قيد الانتظار',
                                'processing' => 'جاري التجهيز',
                                'shipped' => 'تم الشحن',
                                'delivered' => 'تم التوصيل',
                                'cancelled' => 'ملغي',
                            ])
                            ->required()
                            ->native(false),
                        
                        TextInput::make('order_number')
                            ->label('رقم الطلب')
                            ->disabled()
                            ->dehydrated(false),
                    ])->columnSpan(1),

                Section::make('معلومات الزبون')
                    ->schema([
                        Select::make('user_id')
                            ->label('الزبون')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('customer_phone')
                            ->label('رقم الهاتف')
                            ->tel(),

                        TextInput::make('shipping_address')
                            ->label('عنوان التوصيل')
                            ->columnSpanFull(),
                    ])->columnSpan(2),

                Section::make('تفاصيل المبالغ')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('total_amount')
                                    ->label('المبلغ الإجمالي')
                                    ->numeric()
                                    ->prefix('IQD')
                                    ->required(),
                                
                                TextInput::make('discount_amount')
                                    ->label('مبلغ الخصم')
                                    ->numeric()
                                    ->prefix('IQD')
                                    ->default(0),

                                TextInput::make('final_amount')
                                    ->label('المبلغ الصافي')
                                    ->numeric()
                                    ->prefix('IQD')
                                    ->required(),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
