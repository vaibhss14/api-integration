<?php

namespace App\Filament\Admin\Resources\QuestionCategories;

use App\Filament\Admin\Resources\QuestionCategories\Pages\CreateQuestionCategory;
use App\Filament\Admin\Resources\QuestionCategories\Pages\EditQuestionCategory;
use App\Filament\Admin\Resources\QuestionCategories\Pages\ListQuestionCategories;
use App\Filament\Admin\Resources\QuestionCategories\Schemas\QuestionCategoryForm;
use App\Filament\Admin\Resources\QuestionCategories\Tables\QuestionCategoriesTable;
use App\Models\QuestionCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuestionCategoryResource extends Resource
{
    protected static ?string $model = QuestionCategory::class;

    protected static ?int $navigationSort = 8;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'category_name';

    public static function form(Schema $schema): Schema
    {
        return QuestionCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionCategoriesTable::configure($table);
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
            'index' => ListQuestionCategories::route('/'),
            'create' => CreateQuestionCategory::route('/create'),
            'edit' => EditQuestionCategory::route('/{record}/edit'),
        ];
    }
}
