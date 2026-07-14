<?php

namespace App\Filament\Admin\Resources\SurveyQuotas\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SurveyQuotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('survey_id')
                    ->required()
                    ->numeric(),
                TextInput::make('quota_id')
                    ->required()
                    ->numeric(),
                TextInput::make('quota_name')
                    ->required(),
                TextInput::make('total_remaining')
                    ->numeric(),
                TextInput::make('qualification_id')
                    ->numeric(),
                TextInput::make('answer_id'),
                DateTimePicker::make('update_timestamp'),
            ]);
    }
}
