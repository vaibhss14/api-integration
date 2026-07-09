<?php

namespace App\Filament\Admin\Resources\BusinessVerticals\Pages;

use App\Filament\Admin\Resources\BusinessVerticals\BusinessVerticalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBusinessVertical extends EditRecord
{
    protected static string $resource = BusinessVerticalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
