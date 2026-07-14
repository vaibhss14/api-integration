<?php

namespace App\Filament\Admin\Resources\SurveyGroups\Pages;

use App\Filament\Admin\Resources\SurveyGroups\SurveyGroupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSurveyGroup extends EditRecord
{
    protected static string $resource = SurveyGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
