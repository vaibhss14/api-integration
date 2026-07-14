<?php

namespace App\Filament\Admin\Resources\SupplierBlockedRespondents\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SupplierBlockedRespondentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('completes')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('reconcile_rate')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                DateTimePicker::make('updated_timestamp'),
            ]);
    }
}
