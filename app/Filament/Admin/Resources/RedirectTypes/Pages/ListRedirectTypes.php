<?php

namespace App\Filament\Admin\Resources\RedirectTypes\Pages;

use App\Filament\Admin\Resources\RedirectTypes\RedirectTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRedirectTypes extends ListRecords
{
    protected static string $resource = RedirectTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
