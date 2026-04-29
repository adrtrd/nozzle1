<?php

namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('صورة المنتج')
                    ->circular(),
                
                TextColumn::make('name')
                    ->label('اسم المنتج')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('التصنيف')
                    ->badge()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->money('IQD')
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('المخزن')
                    ->numeric()
                    ->sortable(),

                ToggleColumn::make('is_available')
                    ->label('متوفر'),

                IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
