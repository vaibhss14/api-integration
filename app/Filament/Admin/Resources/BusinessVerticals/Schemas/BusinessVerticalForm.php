<?php

namespace App\Filament\Admin\Resources\BusinessVerticals\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BusinessVerticalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('business_vertical_id')
                    ->required()
                    ->numeric(),
                TextInput::make('description')
                    ->required(),
            ]);
    }
}
