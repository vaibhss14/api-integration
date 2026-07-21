<?php

namespace App\Filament\Admin\Resources\BusinessVerticals;

use App\Filament\Admin\Resources\BusinessVerticals\Pages\EditBusinessVertical;
use App\Filament\Admin\Resources\BusinessVerticals\Pages\ListBusinessVerticals;
use App\Filament\Admin\Resources\BusinessVerticals\Schemas\BusinessVerticalForm;
use App\Filament\Admin\Resources\BusinessVerticals\Tables\BusinessVerticalsTable;
use App\Models\BusinessVertical;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BusinessVerticalResource extends Resource
{
    protected static ?string $model = BusinessVertical::class;

    protected static ?int $navigationSort = 9;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'description';

    public static function form(Schema $schema): Schema
    {
        return BusinessVerticalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BusinessVerticalsTable::configure($table);
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
            'index' => ListBusinessVerticals::route('/'),
            'edit' => EditBusinessVertical::route('/{record}/edit'),
        ];
    }
}
