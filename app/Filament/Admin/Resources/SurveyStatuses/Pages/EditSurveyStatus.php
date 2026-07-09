<?php

namespace App\Filament\Admin\Resources\SurveyStatuses\Pages;

use App\Filament\Admin\Resources\SurveyStatuses\SurveyStatusResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSurveyStatus extends EditRecord
{
    protected static string $resource = SurveyStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
