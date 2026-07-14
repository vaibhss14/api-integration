<?php

namespace App\Filament\Admin\Resources\SupplierBlockedIpAddresses\Pages;

use App\Filament\Admin\Resources\SupplierBlockedIpAddresses\SupplierBlockedIpAddressResource;
use Filament\Resources\Pages\ListRecords;

class ListSupplierBlockedIpAddresses extends ListRecords
{
    protected static string $resource = SupplierBlockedIpAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
