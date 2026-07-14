<?php

namespace App\Filament\Admin\Resources\SurveyQualifications\Pages;

use App\Filament\Admin\Resources\SurveyQualifications\SurveyQualificationResource;
use Filament\Resources\Pages\ListRecords;

class ListSurveyQualifications extends ListRecords
{
    protected static string $resource = SurveyQualificationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
