<?php

namespace App\Filament\Admin\Resources\QuestionCategories\Pages;

use App\Filament\Admin\Resources\QuestionCategories\QuestionCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQuestionCategories extends ListRecords
{
    protected static string $resource = QuestionCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
