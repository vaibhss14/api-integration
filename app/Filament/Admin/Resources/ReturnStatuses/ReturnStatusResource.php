<?php

namespace App\Filament\Admin\Resources\ReturnStatuses;

use App\Filament\Admin\Resources\ReturnStatuses\Pages\EditReturnStatus;
use App\Filament\Admin\Resources\ReturnStatuses\Pages\ListReturnStatuses;
use App\Filament\Admin\Resources\ReturnStatuses\Schemas\ReturnStatusForm;
use App\Filament\Admin\Resources\ReturnStatuses\Tables\ReturnStatusesTable;
use App\Models\ReturnStatus;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReturnStatusResource extends Resource
{
    protected static ?string $model = ReturnStatus::class;

    protected static ?int $navigationSort = 8;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'description';

    public static function form(Schema $schema): Schema
    {
        return ReturnStatusForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReturnStatusesTable::configure($table);
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
            'index' => ListReturnStatuses::route('/'),
            'edit' => EditReturnStatus::route('/{record}/edit'),
        ];
    }
}
