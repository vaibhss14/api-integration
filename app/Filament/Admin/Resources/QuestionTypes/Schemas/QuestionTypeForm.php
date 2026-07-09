<?php

namespace App\Filament\Admin\Resources\QuestionTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuestionTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question_type_id')
                    ->required()
                    ->numeric(),
                TextInput::make('question_type_name')
                    ->required(),
            ]);
    }
}
