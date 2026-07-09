<?php

namespace App\Filament\Admin\Resources\Industries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class IndustriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('industry_id')
                ->label('Industry ID')
                ->sortable(),

            TextColumn::make('industry_name')
                ->label('Industry Name')
                ->searchable(),

            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),

            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable(),
        ])
        ->recordActions([
                EditAction::make(),
            ]);
       
    }
}
