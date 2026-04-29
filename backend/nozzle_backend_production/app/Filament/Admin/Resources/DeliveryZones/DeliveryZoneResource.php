<?php

namespace App\Filament\Admin\Resources\DeliveryZones;

use App\Filament\Admin\Resources\DeliveryZones\Pages\ManageDeliveryZones;
use App\Models\DeliveryZone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DeliveryZoneResource extends Resource
{
    protected static ?string $model = DeliveryZone::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-truck';
    protected static string|\UnitEnum|null $navigationGroup = 'الإعدادات';
    protected static ?string $navigationLabel = 'إعدادات التوصيل';
    protected static ?string $modelLabel = 'منطقة توصيل';
    protected static ?string $pluralModelLabel = 'مناطق التوصيل';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم المنطقة')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city_or_region')
                    ->label('المدينة أو الإقليم')
                    ->maxLength(255),
                Forms\Components\TextInput::make('delivery_fee')
                    ->label('رسوم التوصيل')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Forms\Components\TextInput::make('minimum_order_amount')
                    ->label('الحد الأدنى للطلب')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Forms\Components\TextInput::make('estimated_time')
                    ->label('الوقت المتوقع للتوصيل')
                    ->placeholder('مثال: 30-45 دقيقة')
                    ->maxLength(255),
                Forms\Components\TagsInput::make('included_areas')
                    ->label('الأحياء المشمولة')
                    ->placeholder('أضف حياً ثم اضغط Enter')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label('مفعل')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('المنطقة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('delivery_fee')
                    ->label('الرسوم')
                    ->money('SAR'),
                Tables\Columns\TextColumn::make('minimum_order_amount')
                    ->label('الحد الأدنى')
                    ->money('SAR'),
                Tables\Columns\TextColumn::make('estimated_time')
                    ->label('الوقت المتوقع')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('مفعل')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageDeliveryZones::route('/'),
        ];
    }
}
