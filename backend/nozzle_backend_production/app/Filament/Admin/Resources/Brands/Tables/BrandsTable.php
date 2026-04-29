<?php

namespace App\Filament\Admin\Resources\Brands\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BrandsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('الشعار')
                    ->circular(),
                
                TextColumn::make('name')
                    ->label('الماركة')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('products_count')
                    ->label('عدد المنتجات')
                    ->counts('products'),
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
