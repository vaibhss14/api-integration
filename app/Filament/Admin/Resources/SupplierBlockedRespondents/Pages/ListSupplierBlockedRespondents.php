<?php

namespace App\Filament\Admin\Resources\SupplierBlockedRespondents\Pages;

use App\Filament\Admin\Resources\SupplierBlockedRespondents\SupplierBlockedRespondentResource;
use Filament\Resources\Pages\ListRecords;

class ListSupplierBlockedRespondents extends ListRecords
{
    protected static string $resource = SupplierBlockedRespondentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
