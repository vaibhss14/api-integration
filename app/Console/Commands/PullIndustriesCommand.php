<?php

namespace App\Console\Commands;

use App\Models\Industry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullIndustriesCommand extends Command
{
    protected $signature = 'industries:pull';

    protected $description = 'Pull industries from API and store them';

    public function handle()
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => trim(env('ACCESS_TOKEN')),
            ])
            ->get(env('API_BASE_URL').'/industry-list');

        if (! $response->successful()) {
            $this->error('Failed to fetch industries.');

            return Command::FAILURE;
        }

        $industries = $response->json('data');

        if (empty($industries)) {
            $this->error('No industries found.');

            return Command::FAILURE;
        }

        foreach ($industries as $industry) {

            Industry::updateOrCreate(
                [
                    'industry_id' => $industry['industryId'],
                ],
                [
                    'industry_name' => trim($industry['industryName']),
                ]
            );
        }

        $this->info(count($industries).' industries imported successfully.');

        return Command::SUCCESS;
    }
}
