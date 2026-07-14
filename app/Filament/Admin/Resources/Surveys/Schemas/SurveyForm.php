<?php

namespace App\Filament\Admin\Resources\Surveys\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SurveyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('survey_id')
                    ->required()
                    ->numeric(),
                TextInput::make('survey_name')
                    ->required(),
                TextInput::make('industry_id')
                    ->required()
                    ->numeric(),
                TextInput::make('country_id')
                    ->required()
                    ->numeric(),
                TextInput::make('study_type_id')
                    ->required()
                    ->numeric(),
                TextInput::make('cpi')
                    ->numeric(),
                TextInput::make('loi')
                    ->numeric(),
                TextInput::make('ir')
                    ->numeric(),
                Toggle::make('collect_pii')
                    ->required(),
                Toggle::make('is_mobile')
                    ->required(),
                Toggle::make('is_tablet')
                    ->required(),
                Toggle::make('is_desktop')
                    ->required(),
                Toggle::make('is_survey_group_exist')
                    ->required(),
                TextInput::make('client_id')
                    ->numeric(),
                TextInput::make('account_id')
                    ->numeric(),
                Textarea::make('live_link')
                    ->columnSpanFull(),
                Textarea::make('test_link')
                    ->columnSpanFull(),
                DateTimePicker::make('update_timestamp'),
                DateTimePicker::make('qual_update_timestamp'),
                DateTimePicker::make('quota_update_timestamp'),
                DateTimePicker::make('group_update_timestamp'),
            ]);
    }
}
