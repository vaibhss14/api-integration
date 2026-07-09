<?php

namespace App\Filament\Admin\Resources\StudyTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudyTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('study_type_id')
                    ->required()
                    ->numeric(),
                TextInput::make('study_name')
                    ->required(),
            ]);
    }
}
