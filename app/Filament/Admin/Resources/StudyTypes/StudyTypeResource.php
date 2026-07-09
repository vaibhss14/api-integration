<?php

namespace App\Filament\Admin\Resources\StudyTypes;

use App\Filament\Admin\Resources\StudyTypes\Pages\CreateStudyType;
use App\Filament\Admin\Resources\StudyTypes\Pages\EditStudyType;
use App\Filament\Admin\Resources\StudyTypes\Pages\ListStudyTypes;
use App\Filament\Admin\Resources\StudyTypes\Schemas\StudyTypeForm;
use App\Filament\Admin\Resources\StudyTypes\Tables\StudyTypesTable;
use App\Models\StudyType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudyTypeResource extends Resource
{
    protected static ?string $model = StudyType::class;

    protected static ?int $navigationSort = 3;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'study_name';

    public static function form(Schema $schema): Schema
    {
        return StudyTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudyTypesTable::configure($table);
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
            'index' => ListStudyTypes::route('/'),
            'create' => CreateStudyType::route('/create'),
            'edit' => EditStudyType::route('/{record}/edit'),
        ];
    }
}
