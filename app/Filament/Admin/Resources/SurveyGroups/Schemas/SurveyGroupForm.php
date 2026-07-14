<?php

namespace App\Filament\Admin\Resources\SurveyGroups\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SurveyGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('survey_id')
                    ->required()
                    ->numeric(),
                TextInput::make('survey_group_id')
                    ->required(),
                TextInput::make('survey_group_name')
                    ->required(),
                TextInput::make('grouped_survey_id')
                    ->required()
                    ->numeric(),
                TextInput::make('return_restriction_status_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
