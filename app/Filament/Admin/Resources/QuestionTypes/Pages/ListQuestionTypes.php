<?php

namespace App\Filament\Admin\Resources\QuestionTypes\Pages;

use App\Filament\Admin\Resources\QuestionTypes\QuestionTypeResource;
use Filament\Resources\Pages\ListRecords;

class ListQuestionTypes extends ListRecords
{
    protected static string $resource = QuestionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
