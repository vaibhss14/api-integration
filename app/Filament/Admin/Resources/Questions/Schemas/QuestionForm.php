<?php

namespace App\Filament\Admin\Resources\Questions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
         return $schema
            ->components([

                TextInput::make('question_id')
                    ->label('Question ID')
                    ->numeric()
                    ->required(),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->required(),

                TextInput::make('question_category_id')
                    ->label('Category ID')
                    ->numeric(),

                TextInput::make('question_type_id')
                    ->label('Question Type ID')
                    ->numeric(),

                TextInput::make('localization_code')
                    ->label('Localization Code')
                    ->required(),

            ]);
    }
}
