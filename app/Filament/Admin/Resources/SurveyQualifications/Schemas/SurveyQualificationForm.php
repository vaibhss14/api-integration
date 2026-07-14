<?php

namespace App\Filament\Admin\Resources\SurveyQualifications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SurveyQualificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('survey_id')
                    ->required()
                    ->numeric(),
                TextInput::make('qualification_id')
                    ->required()
                    ->numeric(),
                TextInput::make('answer_id')
                    ->required(),
                DateTimePicker::make('update_timestamp'),
            ]);
    }
}
