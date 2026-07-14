<?php

namespace App\Filament\Admin\Resources\QuestionAnswers\Pages;

use App\Filament\Admin\Resources\QuestionAnswers\QuestionAnswerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQuestionAnswer extends EditRecord
{
    protected static string $resource = QuestionAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
