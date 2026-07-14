<?php

namespace App\Filament\Admin\Resources\QuestionAnswers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuestionAnswerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('answer_id')
                    ->required()
                    ->numeric(),
                Select::make('question_id')
                    ->relationship('question', 'description')
                    ->searchable()
                    ->required(),
                TextInput::make('description')
                    ->required(),
            ]);
    }
}
