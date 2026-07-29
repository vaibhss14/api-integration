<?php

namespace App\Jobs;

use App\Models\ReturnStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullReturnStatusesJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 120;

    public function backoff(): array
    {
        return [60, 300, 600];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => config('services.supplier_api.access_token'),
            ])
            ->get(
                config('services.supplier_api.base_url')
                .'/support/return-status'
            );

        if (! $response->successful()) {

            logger()->error('Failed to fetch return statuses.');

            return;
        }

        $returnStatuses = $response->json('data');

        if (empty($returnStatuses)) {

            logger()->warning('No return statuses found.');

            return;
        }

        foreach ($returnStatuses as $status) {

            ReturnStatus::updateOrCreate(
                [
                    'return_status_id' => $status['ReturnStatusId'],
                ],
                [
                    'description' => trim($status['Description']),
                ]
            );
        }

        logger()->info('Return statuses synchronized successfully.');
    }
}
