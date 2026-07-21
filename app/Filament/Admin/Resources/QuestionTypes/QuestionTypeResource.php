<?php

namespace App\Filament\Admin\Resources\QuestionTypes;

use App\Filament\Admin\Resources\QuestionTypes\Pages\EditQuestionType;
use App\Filament\Admin\Resources\QuestionTypes\Pages\ListQuestionTypes;
use App\Filament\Admin\Resources\QuestionTypes\Schemas\QuestionTypeForm;
use App\Filament\Admin\Resources\QuestionTypes\Tables\QuestionTypesTable;
use App\Models\QuestionType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuestionTypeResource extends Resource
{
    protected static ?string $model = QuestionType::class;

    protected static ?int $navigationSort = 10;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'question_type_name';

    public static function form(Schema $schema): Schema
    {
        return QuestionTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionTypesTable::configure($table);
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
            'index' => ListQuestionTypes::route('/'),
            'edit' => EditQuestionType::route('/{record}/edit'),
        ];
    }
}
