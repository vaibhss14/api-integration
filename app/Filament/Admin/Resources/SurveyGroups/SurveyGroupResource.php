<?php

namespace App\Filament\Admin\Resources\SurveyGroups;

use App\Filament\Admin\Resources\SurveyGroups\Pages\EditSurveyGroup;
use App\Filament\Admin\Resources\SurveyGroups\Pages\ListSurveyGroups;
use App\Filament\Admin\Resources\SurveyGroups\Schemas\SurveyGroupForm;
use App\Filament\Admin\Resources\SurveyGroups\Tables\SurveyGroupsTable;
use App\Models\SurveyGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SurveyGroupResource extends Resource
{
    protected static ?string $model = SurveyGroup::class;

    protected static ?int $navigationSort = 16;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'survey_group_name';

    public static function form(Schema $schema): Schema
    {
        return SurveyGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SurveyGroupsTable::configure($table);
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
            'index' => ListSurveyGroups::route('/'),
            'edit' => EditSurveyGroup::route('/{record}/edit'),
        ];
    }
}
