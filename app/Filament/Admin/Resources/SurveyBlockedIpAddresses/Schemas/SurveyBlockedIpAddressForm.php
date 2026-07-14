<?php

namespace App\Filament\Admin\Resources\SurveyBlockedIpAddresses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SurveyBlockedIpAddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('survey_id')
                    ->required()
                    ->numeric(),
                TextInput::make('ip_address')
                    ->required(),
                DateTimePicker::make('update_timestamp'),
            ]);
    }
}
