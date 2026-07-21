<?php

namespace App\Filament\Admin\Resources\ReturnStatuses\Pages;

use App\Filament\Admin\Resources\ReturnStatuses\ReturnStatusResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReturnStatus extends EditRecord
{
    protected static string $resource = ReturnStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
