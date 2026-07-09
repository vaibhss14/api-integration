<?php

namespace App\Filament\Admin\Resources\StudyTypes\Pages;

use App\Filament\Admin\Resources\StudyTypes\StudyTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudyType extends CreateRecord
{
    protected static string $resource = StudyTypeResource::class;
}
