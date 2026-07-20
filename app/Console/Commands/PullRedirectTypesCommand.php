<?php

namespace App\Console\Commands;

use App\Models\RedirectType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullRedirectTypesCommand extends Command
{
    protected $signature = 'redirect-types:pull';

    protected $description = 'Pull redirect types from API and store them';

    public function handle()
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => trim(env('ACCESS_TOKEN')),
            ])
            ->get(env('API_BASE_URL').'/redirect-types');

        if (! $response->successful()) {
            $this->error('Failed to fetch redirect types.');

            return Command::FAILURE;
        }

        $redirectTypes = $response->json('data');

        if (empty($redirectTypes)) {
            $this->error('No redirect types found.');

            return Command::FAILURE;
        }

        foreach ($redirectTypes as $redirectType) {

            RedirectType::updateOrCreate(
                [
                    'redirect_type_id' => $redirectType['RedirectTypeId'],
                ],
                [
                    'description' => trim($redirectType['Description']),
                ]
            );
        }

        $this->info(count($redirectTypes).' redirect types imported successfully.');

        return Command::SUCCESS;
    }
}
