<?php

namespace App\Filament\Admin\Resources\SupplierBlockedRespondents\Pages;

use App\Filament\Admin\Resources\SupplierBlockedRespondents\SupplierBlockedRespondentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSupplierBlockedRespondent extends EditRecord
{
    protected static string $resource = SupplierBlockedRespondentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
