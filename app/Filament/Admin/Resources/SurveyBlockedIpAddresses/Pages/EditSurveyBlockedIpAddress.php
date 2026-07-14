<?php

namespace App\Filament\Admin\Resources\SurveyBlockedIpAddresses\Pages;

use App\Filament\Admin\Resources\SurveyBlockedIpAddresses\SurveyBlockedIpAddressResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSurveyBlockedIpAddress extends EditRecord
{
    protected static string $resource = SurveyBlockedIpAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
