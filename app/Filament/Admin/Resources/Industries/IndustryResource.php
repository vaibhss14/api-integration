<?php

namespace App\Filament\Admin\Resources\Industries;

use App\Filament\Admin\Resources\Industries\Pages\EditIndustry;
use App\Filament\Admin\Resources\Industries\Pages\ListIndustries;
use App\Filament\Admin\Resources\Industries\Schemas\IndustryForm;
use App\Filament\Admin\Resources\Industries\Tables\IndustriesTable;
use App\Models\Industry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IndustryResource extends Resource
{
    protected static ?string $model = Industry::class;

    protected static ?int $navigationSort = 4;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'industry_name';

    public static function form(Schema $schema): Schema
    {
        return IndustryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IndustriesTable::configure($table);
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
            'index' => ListIndustries::route('/'),
            'edit' => EditIndustry::route('/{record}/edit'),
        ];
    }
}
