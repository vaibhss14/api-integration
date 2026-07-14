<?php

namespace App\Filament\Admin\Resources\SurveyQualifications\Pages;

use App\Filament\Admin\Resources\SurveyQualifications\SurveyQualificationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSurveyQualification extends EditRecord
{
    protected static string $resource = SurveyQualificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
