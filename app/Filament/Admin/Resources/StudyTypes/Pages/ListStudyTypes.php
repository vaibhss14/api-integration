<?php

namespace App\Filament\Admin\Resources\StudyTypes\Pages;

use App\Filament\Admin\Resources\StudyTypes\StudyTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudyTypes extends ListRecords
{
    protected static string $resource = StudyTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
