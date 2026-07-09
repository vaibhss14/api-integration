<?php

namespace App\Filament\Admin\Resources\QuestionCategories\Pages;

use App\Filament\Admin\Resources\QuestionCategories\QuestionCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestionCategory extends CreateRecord
{
    protected static string $resource = QuestionCategoryResource::class;
}
