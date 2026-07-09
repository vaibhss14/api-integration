<?php

namespace App\Filament\Admin\Resources\QuestionCategories\Pages;

use App\Filament\Admin\Resources\QuestionCategories\QuestionCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQuestionCategory extends EditRecord
{
    protected static string $resource = QuestionCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
