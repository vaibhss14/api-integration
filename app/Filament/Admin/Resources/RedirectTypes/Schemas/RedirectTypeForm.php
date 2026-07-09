<?php

namespace App\Filament\Admin\Resources\RedirectTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RedirectTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('redirect_type_id')
                    ->required()
                    ->numeric(),
                TextInput::make('description')
                    ->required(),
            ]);
    }
}
