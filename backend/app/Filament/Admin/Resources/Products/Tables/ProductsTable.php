<?php

namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                    ->label('المنتج')
                    ->rounded(),
                
                TextColumn::make('name')
                    ->label('')
                    ->description(fn ($record) => $record->sku ? 'رمز: ' . $record->sku : '')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('القسم / الصنف')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->money('IQD')
                    ->sortable()
                    ->color('danger'),

                TextColumn::make('is_available')
                    ->label('التوفر والمخزون')
                    ->badge()
                    ->state(fn ($record) => $record->is_available ? 'متوفر' : 'غير متوفر')
                    ->color(fn ($state) => $state === 'متوفر' ? 'success' : 'danger'),

                ToggleColumn::make('is_featured')
                    ->label('الظهور'),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category')
                    ->label('القسم')
                    ->relationship('category', 'name'),
                
                \Filament\Tables\Filters\TernaryFilter::make('is_available')
                    ->label('التوفر')
                    ->placeholder('الكل')
                    ->trueLabel('متوفر')
                    ->falseLabel('غير متوفر'),

                \Filament\Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('المنتجات المميزة')
                    ->placeholder('الكل')
                    ->trueLabel('مميز')
                    ->falseLabel('عادي'),
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
