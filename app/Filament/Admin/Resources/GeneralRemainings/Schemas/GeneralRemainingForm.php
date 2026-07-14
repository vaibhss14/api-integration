<?php

namespace App\Filament\Admin\Resources\GeneralRemainings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GeneralRemainingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('survey_id')
                    ->required()
                    ->numeric(),
                TextInput::make('total_remaining')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_reserved_remaining')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('reservation_expiration'),
            ]);
    }
}
