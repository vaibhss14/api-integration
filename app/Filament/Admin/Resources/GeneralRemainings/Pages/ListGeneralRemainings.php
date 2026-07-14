<?php

namespace App\Filament\Admin\Resources\GeneralRemainings\Pages;

use App\Filament\Admin\Resources\GeneralRemainings\GeneralRemainingResource;
use Filament\Resources\Pages\ListRecords;

class ListGeneralRemainings extends ListRecords
{
    protected static string $resource = GeneralRemainingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
