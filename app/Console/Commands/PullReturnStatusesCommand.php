<?php

namespace App\Console\Commands;

use App\Models\ReturnStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullReturnStatusesCommand extends Command
{
    protected $signature = 'return-statuses:pull';

    protected $description = 'Pull return statuses from API';

    public function handle()
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => trim(env('ACCESS_TOKEN')),
            ])
            ->get(
                env('API_BASE_URL').'/support/return-status'
            );

        if (! $response->successful()) {

            $this->error('Failed to fetch return statuses.');

            return Command::FAILURE;
        }

        foreach ($response->json('data') as $status) {

            ReturnStatus::updateOrCreate(
                [
                    'return_status_id' => $status['ReturnStatusId'],
                ],
                [
                    'description' => $status['Description'],
                ]
            );
        }

        $this->info('Return statuses imported successfully.');

        return Command::SUCCESS;
    }
}
