<?php

namespace App\Filament\Admin\Resources\QuestionTypes\Pages;

use App\Filament\Admin\Resources\QuestionTypes\QuestionTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQuestionType extends EditRecord
{
    protected static string $resource = QuestionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
