<?php

namespace App\Filament\Admin\Resources\SurveyBlockedIpAddresses;

use App\Filament\Admin\Resources\SurveyBlockedIpAddresses\Pages\EditSurveyBlockedIpAddress;
use App\Filament\Admin\Resources\SurveyBlockedIpAddresses\Pages\ListSurveyBlockedIpAddresses;
use App\Filament\Admin\Resources\SurveyBlockedIpAddresses\Schemas\SurveyBlockedIpAddressForm;
use App\Filament\Admin\Resources\SurveyBlockedIpAddresses\Tables\SurveyBlockedIpAddressesTable;
use App\Models\SurveyBlockedIpAddress;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SurveyBlockedIpAddressResource extends Resource
{
    protected static ?string $model = SurveyBlockedIpAddress::class;

    protected static ?int $navigationSort = 17;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ip_address';

    public static function form(Schema $schema): Schema
    {
        return SurveyBlockedIpAddressForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SurveyBlockedIpAddressesTable::configure($table);
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
            'index' => ListSurveyBlockedIpAddresses::route('/'),
            'edit' => EditSurveyBlockedIpAddress::route('/{record}/edit'),
        ];
    }
}
