<?php

namespace App\Filament\Admin\Resources\RedirectTypes\Pages;

use App\Filament\Admin\Resources\RedirectTypes\RedirectTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRedirectType extends EditRecord
{
    protected static string $resource = RedirectTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
