<?php

namespace App\Filament\Admin\Resources\QuestionAnswers;

use App\Filament\Admin\Resources\QuestionAnswers\Pages\EditQuestionAnswer;
use App\Filament\Admin\Resources\QuestionAnswers\Pages\ListQuestionAnswers;
use App\Filament\Admin\Resources\QuestionAnswers\Schemas\QuestionAnswerForm;
use App\Filament\Admin\Resources\QuestionAnswers\Tables\QuestionAnswersTable;
use App\Models\QuestionAnswer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuestionAnswerResource extends Resource
{
    protected static ?string $model = QuestionAnswer::class;

    protected static ?int $navigationSort = 13;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'description';

    public static function form(Schema $schema): Schema
    {
        return QuestionAnswerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionAnswersTable::configure($table);
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
            'index' => ListQuestionAnswers::route('/'),
            'edit' => EditQuestionAnswer::route('/{record}/edit'),
        ];
    }
}
