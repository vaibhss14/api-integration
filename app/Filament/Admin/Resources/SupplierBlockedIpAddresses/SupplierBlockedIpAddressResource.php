<?php

namespace App\Filament\Admin\Resources\SupplierBlockedIpAddresses;

use App\Filament\Admin\Resources\SupplierBlockedIpAddresses\Pages\EditSupplierBlockedIpAddress;
use App\Filament\Admin\Resources\SupplierBlockedIpAddresses\Pages\ListSupplierBlockedIpAddresses;
use App\Filament\Admin\Resources\SupplierBlockedIpAddresses\Schemas\SupplierBlockedIpAddressForm;
use App\Filament\Admin\Resources\SupplierBlockedIpAddresses\Tables\SupplierBlockedIpAddressesTable;
use App\Models\SupplierBlockedIpAddress;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SupplierBlockedIpAddressResource extends Resource
{
    protected static ?string $model = SupplierBlockedIpAddress::class;

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ip_address';

    public static function form(Schema $schema): Schema
    {
        return SupplierBlockedIpAddressForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SupplierBlockedIpAddressesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSupplierBlockedIpAddresses::route('/'),
            'edit' => EditSupplierBlockedIpAddress::route('/{record}/edit'),
        ];
    }
}
