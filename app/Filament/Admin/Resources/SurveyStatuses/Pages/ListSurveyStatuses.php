<?php

namespace App\Filament\Admin\Resources\SurveyStatuses\Pages;

use App\Filament\Admin\Resources\SurveyStatuses\SurveyStatusResource;
use Filament\Resources\Pages\ListRecords;

class ListSurveyStatuses extends ListRecords
{
    protected static string $resource = SurveyStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
