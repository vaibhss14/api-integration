<?php

namespace App\Filament\Admin\Resources\RedirectTypes;

use App\Filament\Admin\Resources\RedirectTypes\Pages\EditRedirectType;
use App\Filament\Admin\Resources\RedirectTypes\Pages\ListRedirectTypes;
use App\Filament\Admin\Resources\RedirectTypes\Schemas\RedirectTypeForm;
use App\Filament\Admin\Resources\RedirectTypes\Tables\RedirectTypesTable;
use App\Models\RedirectType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RedirectTypeResource extends Resource
{
    protected static ?string $model = RedirectType::class;

    protected static ?int $navigationSort = 7;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'description';

    public static function form(Schema $schema): Schema
    {
        return RedirectTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RedirectTypesTable::configure($table);
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
            'index' => ListRedirectTypes::route('/'),
            'edit' => EditRedirectType::route('/{record}/edit'),
        ];
    }
}
