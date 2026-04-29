<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Section::make('بيانات القسم')
                    ->description('أدخل معلومات الصنف أو الفئة الأساسية هنا')
                    ->schema([
                        TextInput::make('name')
                            ->label('اسم القسم')
                            ->placeholder('مثلاً: غسيل السيارات، تبديل الزيت...')
                            ->required()
                            ->maxLength(255),
                        Select::make('icon')
                            ->label('أيقونة القسم')
                            ->options([
                                'oil_barrel' => 'برميل زيت',
                                'filter_alt' => 'فلتر',
                                'water_drop' => 'سوائل/مياه',
                                'battery_charging_full' => 'بطارية',
                                'tire_repair' => 'إطارات',
                                'build' => 'أدوات/بناء',
                                'cleaning_services' => 'تنظيف',
                                'ac_unit' => 'تبريد/تكييف',
                                'directions_car' => 'سيارة',
                                'local_gas_station' => 'محطة وقود',
                                'inventory_2' => 'مخزن',
                                'folder' => 'مجلد (افتراضي)',
                            ])
                            ->default('folder')
                            ->native(false),
                        ColorPicker::make('color')
                            ->label('لون التمييز')
                            ->default('#1E4DB7'),
                        TextInput::make('order_index')
                            ->label('ترتيب العرض')
                            ->helperText('الرقم الأصغر يظهر أولاً')
                            ->numeric()
                            ->default(0),
                        Textarea::make('description')
                            ->label('وصف القسم')
                            ->placeholder('أدخل وصفاً مختصراً لهذا القسم...')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->label('صورة القسم')
                            ->image()
                            ->directory('categories')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);

    }
}
