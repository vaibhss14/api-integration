<?php

namespace App\Filament\Admin\Resources\Industries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IndustryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('industry_id')
                    ->label('Industry ID')
                    ->numeric()
                    ->required(),

                TextInput::make('industry_name')
                    ->label('Industry Name')
                    ->required(),
            ]);
    }
}
