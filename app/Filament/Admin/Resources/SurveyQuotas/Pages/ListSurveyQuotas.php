<?php

namespace App\Filament\Admin\Resources\SurveyQuotas\Pages;

use App\Filament\Admin\Resources\SurveyQuotas\SurveyQuotaResource;
use Filament\Resources\Pages\ListRecords;

class ListSurveyQuotas extends ListRecords
{
    protected static string $resource = SurveyQuotaResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
