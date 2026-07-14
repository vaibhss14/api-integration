<?php

namespace App\Filament\Admin\Resources\SupplierBlockedIpAddresses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SupplierBlockedIpAddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ip_address')
                    ->required(),
                TextInput::make('completed_surveys')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('reconcile_rate')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('updated_timestamp'),
            ]);
    }
}
