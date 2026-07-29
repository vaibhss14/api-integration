<?php

namespace App\Jobs;

use App\Models\Country;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullCountriesJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 120;

    public function backoff(): array
    {
        return [60, 300, 600];
    }

    public function handle(): void
    {
        $response = Http::acceptJson()
            ->timeout(120)
            ->retry(3, 3000, throw: false)
            ->withHeaders([
                'access-token' => config('services.supplier_api.access_token'),
            ])
            ->get(
                config('services.supplier_api.base_url').'/support/country-list'
            );

        $countries = $response->json('data');

        if (empty($countries)) {
            return;
        }

        foreach ($countries as $country) {

            Country::updateOrCreate(
                [
                    'country_id' => $country['countryId'],
                ],
                [
                    'localization_code' => $country['localizationCode'],
                    'country_name' => $country['countryName'],
                    'languages' => $country['languages'] ?? null,
                ]
            );
        }
    }
}
