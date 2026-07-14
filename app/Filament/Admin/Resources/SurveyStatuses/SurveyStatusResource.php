<?php

namespace App\Filament\Admin\Resources\SurveyStatuses;

use App\Filament\Admin\Resources\SurveyStatuses\Pages\EditSurveyStatus;
use App\Filament\Admin\Resources\SurveyStatuses\Pages\ListSurveyStatuses;
use App\Filament\Admin\Resources\SurveyStatuses\Schemas\SurveyStatusForm;
use App\Filament\Admin\Resources\SurveyStatuses\Tables\SurveyStatusesTable;
use App\Models\SurveyStatus;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SurveyStatusResource extends Resource
{
    protected static ?string $model = SurveyStatus::class;

    protected static ?int $navigationSort = 6;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'status_name';

    public static function form(Schema $schema): Schema
    {
        return SurveyStatusForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SurveyStatusesTable::configure($table);
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
            'index' => ListSurveyStatuses::route('/'),
            'edit' => EditSurveyStatus::route('/{record}/edit'),
        ];
    }
}
