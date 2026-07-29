<?php

namespace App\Jobs;

use App\Models\SupplierBlockedRespondent;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullSupplierBlockedRespondentsJob implements ShouldQueue
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
        $processed = 0;

        $response = Http::acceptJson()
            ->timeout(120)
            ->retry(3, 3000, throw: false)
            ->withHeaders([
                'access-token' => config('services.supplier_api.access_token'),
            ])
            ->get(
                config('services.supplier_api.base_url')
                .'/supplier/supplier-blocked-respondents'
            );

        // Handle "No blocked supplier respondent found"
        if (
            $response->status() === 404 &&
            str_contains(
                $response->json('result.Message', ''),
                'No blocked supplier respondent found'
            )
        ) {

            logger()->warning('No blocked supplier respondents found.');

            return;
        }

        if (
            ! $response->successful() ||
            ! $response->json('result.Success')
        ) {

            logger()->error('Failed to fetch supplier blocked respondents.');

            return;
        }

        foreach ($response->json('blockedRespondents') as $respondent) {

            SupplierBlockedRespondent::updateOrCreate(
                [
                    'user_id' => $respondent['userId'],
                ],
                [
                    'completes' => $respondent['completes'],
                    'reconcile_rate' => $respondent['reconcileRate'],
                    'updated_timestamp' => ! empty($respondent['updatedTimeStamp'])
                        ? Carbon::parse($respondent['updatedTimeStamp'])
                        : null,
                ]
            );

            $processed++;
        }

        logger()->info('Supplier Blocked Respondents synchronized successfully.');
        logger()->info("Records imported: {$processed}");
    }
}
