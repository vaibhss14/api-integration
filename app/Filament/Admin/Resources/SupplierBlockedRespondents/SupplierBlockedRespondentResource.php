<?php

namespace App\Filament\Admin\Resources\SupplierBlockedRespondents;

use App\Filament\Admin\Resources\SupplierBlockedRespondents\Pages\EditSupplierBlockedRespondent;
use App\Filament\Admin\Resources\SupplierBlockedRespondents\Pages\ListSupplierBlockedRespondents;
use App\Filament\Admin\Resources\SupplierBlockedRespondents\Schemas\SupplierBlockedRespondentForm;
use App\Filament\Admin\Resources\SupplierBlockedRespondents\Tables\SupplierBlockedRespondentsTable;
use App\Models\SupplierBlockedRespondent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SupplierBlockedRespondentResource extends Resource
{
    protected static ?string $model = SupplierBlockedRespondent::class;

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'user_id';

    public static function form(Schema $schema): Schema
    {
        return SupplierBlockedRespondentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SupplierBlockedRespondentsTable::configure($table);
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
            'index' => ListSupplierBlockedRespondents::route('/'),
            'edit' => EditSupplierBlockedRespondent::route('/{record}/edit'),
        ];
    }
}
