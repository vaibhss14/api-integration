<?php

namespace App\Filament\Admin\Resources\GeneralRemainings;

use App\Filament\Admin\Resources\GeneralRemainings\Pages\EditGeneralRemaining;
use App\Filament\Admin\Resources\GeneralRemainings\Pages\ListGeneralRemainings;
use App\Filament\Admin\Resources\GeneralRemainings\Schemas\GeneralRemainingForm;
use App\Filament\Admin\Resources\GeneralRemainings\Tables\GeneralRemainingsTable;
use App\Models\GeneralRemaining;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GeneralRemainingResource extends Resource
{
    protected static ?string $model = GeneralRemaining::class;

    protected static ?int $navigationSort = 18;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'survey_id';

    public static function form(Schema $schema): Schema
    {
        return GeneralRemainingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GeneralRemainingsTable::configure($table);
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
            'index' => ListGeneralRemainings::route('/'),
            'edit' => EditGeneralRemaining::route('/{record}/edit'),
        ];
    }
}
