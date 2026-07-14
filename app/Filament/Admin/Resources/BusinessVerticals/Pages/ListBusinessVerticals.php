<?php

namespace App\Filament\Admin\Resources\BusinessVerticals\Pages;

use App\Filament\Admin\Resources\BusinessVerticals\BusinessVerticalResource;
use Filament\Resources\Pages\ListRecords;

class ListBusinessVerticals extends ListRecords
{
    protected static string $resource = BusinessVerticalResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
