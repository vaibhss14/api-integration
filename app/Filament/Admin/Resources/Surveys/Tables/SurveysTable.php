<?php

namespace App\Filament\Admin\Resources\Surveys\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SurveysTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('survey_id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('survey_name')
                    ->searchable(),
                TextColumn::make('industry_id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('country_id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('study_type_id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cpi')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('loi')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ir')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                IconColumn::make('collect_pii')
                    ->boolean(),
                IconColumn::make('is_mobile')
                    ->boolean(),
                IconColumn::make('is_tablet')
                    ->boolean(),
                IconColumn::make('is_desktop')
                    ->boolean(),
                IconColumn::make('is_survey_group_exist')
                    ->boolean(),
                TextColumn::make('client_id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('account_id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('update_timestamp')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('qual_update_timestamp')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('quota_update_timestamp')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('group_update_timestamp')
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
