<?php

namespace App\Filament\Admin\Resources\SupplierBlockedIpAddresses\Pages;

use App\Filament\Admin\Resources\SupplierBlockedIpAddresses\SupplierBlockedIpAddressResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSupplierBlockedIpAddress extends EditRecord
{
    protected static string $resource = SupplierBlockedIpAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
