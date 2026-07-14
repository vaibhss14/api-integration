<?php

namespace App\Filament\Admin\Resources\SurveyQuotas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SurveyQuotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('survey_id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quota_id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quota_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_remaining')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('qualification_id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('answer_id')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('update_timestamp')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
