<?php

namespace App\Filament\Admin\Resources\QuestionAnswers\Pages;

use App\Filament\Admin\Resources\QuestionAnswers\QuestionAnswerResource;
use Filament\Resources\Pages\ListRecords;

class ListQuestionAnswers extends ListRecords
{
    protected static string $resource = QuestionAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
