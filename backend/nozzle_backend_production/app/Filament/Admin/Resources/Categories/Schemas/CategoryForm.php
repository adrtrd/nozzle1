<?php

namespace App\Filament\Admin\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل التصنيف')
                    ->description('أدخل اسم التصنيف وحدد إذا كان يتبع لتصنيف أب.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('اسم التصنيف')
                                    ->required()
                                    ->maxLength(255),
                                
                                Select::make('parent_id')
                                    ->label('التصنيف الأب')
                                    ->relationship('parent', 'name')
                                    ->searchable()
                                    ->preload(),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('icon')
                                    ->label('الأيقونة (FontAwesome)')
                                    ->placeholder('fa-car'),
                                
                                TextInput::make('color')
                                    ->label('اللون')
                                    ->placeholder('#FF0000'),

                                TextInput::make('order_index')
                                    ->label('الترتيب')
                                    ->numeric()
                                    ->default(0),
                            ]),

                        \Filament\Forms\Components\Textarea::make('description')
                            ->label('وصف التصنيف')
                            ->rows(3)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Toggle::make('is_featured')
                            ->label('تصنيف مميز')
                            ->default(false),
                    ]),

                Section::make('صورة التصنيف')
                    ->schema([
                        FileUpload::make('image')
                            ->label('صورة التصنيف / بنر القسم')
                            ->image()
                            ->directory('categories'),
                    ]),
            ]);
    }
}
