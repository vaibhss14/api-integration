<?php

namespace App\Filament\Admin\Resources\SurveyQuotas\Pages;

use App\Filament\Admin\Resources\SurveyQuotas\SurveyQuotaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSurveyQuota extends EditRecord
{
    protected static string $resource = SurveyQuotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
