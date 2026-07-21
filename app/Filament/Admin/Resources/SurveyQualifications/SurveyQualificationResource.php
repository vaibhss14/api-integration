<?php

namespace App\Filament\Admin\Resources\SurveyQualifications;

use App\Filament\Admin\Resources\SurveyQualifications\Pages\EditSurveyQualification;
use App\Filament\Admin\Resources\SurveyQualifications\Pages\ListSurveyQualifications;
use App\Filament\Admin\Resources\SurveyQualifications\Schemas\SurveyQualificationForm;
use App\Filament\Admin\Resources\SurveyQualifications\Tables\SurveyQualificationsTable;
use App\Models\SurveyQualification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SurveyQualificationResource extends Resource
{
    protected static ?string $model = SurveyQualification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 15;

    protected static ?string $recordTitleAttribute = 'qualification_id';

    public static function form(Schema $schema): Schema
    {
        return SurveyQualificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SurveyQualificationsTable::configure($table);
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
            'index' => ListSurveyQualifications::route('/'),
            'edit' => EditSurveyQualification::route('/{record}/edit'),
        ];
    }
}
