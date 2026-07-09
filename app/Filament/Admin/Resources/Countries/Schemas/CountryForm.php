<?php

namespace App\Filament\Admin\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('country_id')
                    ->required()
                    ->numeric(),
                TextInput::make('localization_code')
                    ->required(),
                TextInput::make('country_name')
                    ->required(),
                TextInput::make('languages'),
            ]);
    }
}
