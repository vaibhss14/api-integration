<?php

namespace App\Console\Commands;

use App\Models\BusinessVertical;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullBusinessVerticalsCommand extends Command
{
    protected $signature = 'business-verticals:pull';

    protected $description = 'Pull business verticals from API';

    public function handle()
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => trim(env('ACCESS_TOKEN')),
            ])
            ->get('https://stagingsupply.opinionest.com/api/v1/support/business-verticals');

        if (! $response->successful()) {
            $this->error('Failed to fetch business verticals.');

            return Command::FAILURE;
        }

        $businessVerticals = $response->json('data');

        if (empty($businessVerticals)) {
            $this->error('No business verticals found.');

            return Command::FAILURE;
        }

        foreach ($businessVerticals as $businessVertical) {

            BusinessVertical::updateOrCreate(
                [
                    'business_vertical_id' => $businessVertical['BusinessVerticalId'],
                ],
                [
                    'description' => trim($businessVertical['Description']),
                ]
            );
        }

        $this->info(count($businessVerticals) . ' business verticals imported successfully.');

        return Command::SUCCESS;
    }
}