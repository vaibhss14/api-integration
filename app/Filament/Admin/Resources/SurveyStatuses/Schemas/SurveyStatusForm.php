<?php

namespace App\Filament\Admin\Resources\SurveyStatuses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SurveyStatusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('survey_status_id')
                    ->required()
                    ->numeric(),
                TextInput::make('status_name')
                    ->required(),
            ]);
    }
}
