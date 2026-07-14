<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullCountriesCommand extends Command
{
    protected $signature = 'countries:pull';

    protected $description = 'Pull country list from API and save to countries table';

    public function handle()
    {
        $apiUrl = 'https://stagingsupply.opinionest.com/api/v1/support/country-list';

        $response = Http::withHeaders([
            'access-token' => env('ACCESS_TOKEN'),
            'Accept' => 'application/json',
        ])->get($apiUrl);

        $countries = $response->json('data');

        if (! $countries) {
            $this->error('No country data found.');

            return Command::FAILURE;
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

        $this->info('Countries successfully pulled and saved.');

        return Command::SUCCESS;
    }
}
