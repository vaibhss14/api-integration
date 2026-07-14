<?php

namespace App\Filament\Admin\Resources\QuestionAnswers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuestionAnswersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('answer_id')
                    ->label('Answer ID')
                    ->numeric()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('question_id')
                    ->label('Question ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('question.description')
                    ->label('Question')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('localization_code')
                    ->label('Localization')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Answer')
                    ->searchable(),

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
            ])
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50, 100]);
    }
}
