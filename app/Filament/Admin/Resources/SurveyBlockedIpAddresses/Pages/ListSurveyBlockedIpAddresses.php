<?php

namespace App\Filament\Admin\Resources\SurveyBlockedIpAddresses\Pages;

use App\Filament\Admin\Resources\SurveyBlockedIpAddresses\SurveyBlockedIpAddressResource;
use Filament\Resources\Pages\ListRecords;

class ListSurveyBlockedIpAddresses extends ListRecords
{
    protected static string $resource = SurveyBlockedIpAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
