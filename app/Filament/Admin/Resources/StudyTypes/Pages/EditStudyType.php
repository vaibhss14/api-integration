<?php

namespace App\Filament\Admin\Resources\StudyTypes\Pages;

use App\Filament\Admin\Resources\StudyTypes\StudyTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStudyType extends EditRecord
{
    protected static string $resource = StudyTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
