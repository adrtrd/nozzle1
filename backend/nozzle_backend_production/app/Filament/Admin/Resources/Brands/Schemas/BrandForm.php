<?php

namespace App\Filament\Admin\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل الماركة')
                    ->schema([
                        TextInput::make('name')
                            ->label('اسم الماركة')
                            ->required()
                            ->maxLength(255),
                        
                        FileUpload::make('image')
                            ->label('شعار الماركة')
                            ->image()
                            ->directory('brands'),
                    ]),
            ]);
    }
}
