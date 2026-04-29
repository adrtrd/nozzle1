<?php

namespace App\Filament\Admin\Resources\Banners\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('العنوان')
                    ->required(),
                TextInput::make('subtitle')
                    ->label('العنوان الفرعي'),
                FileUpload::make('image')
                    ->label('الصورة')
                    ->image()
                    ->directory('banners')
                    ->required(),
                Select::make('link_type')
                    ->label('نوع الرابط')
                    ->options([
                        'category' => 'قسم',
                        'product' => 'منتج',
                        'url' => 'رابط خارجي',
                    ]),
                TextInput::make('link_url')
                    ->label('الرابط (URL)')
                    ->url(),
                TextInput::make('order_index')
                    ->label('ترتيب العرض')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true),
            ]);
    }
}
