<?php

namespace App\Filament\Admin\Resources\GeneralRemainings\Pages;

use App\Filament\Admin\Resources\GeneralRemainings\GeneralRemainingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGeneralRemaining extends EditRecord
{
    protected static string $resource = GeneralRemainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
