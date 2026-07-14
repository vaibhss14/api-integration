<?php

namespace App\Filament\Admin\Resources\SurveyGroups\Pages;

use App\Filament\Admin\Resources\SurveyGroups\SurveyGroupResource;
use Filament\Resources\Pages\ListRecords;

class ListSurveyGroups extends ListRecords
{
    protected static string $resource = SurveyGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
