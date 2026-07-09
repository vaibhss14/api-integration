<?php

namespace App\Filament\Admin\Resources\QuestionTypes\Pages;

use App\Filament\Admin\Resources\QuestionTypes\QuestionTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestionType extends CreateRecord
{
    protected static string $resource = QuestionTypeResource::class;
}
