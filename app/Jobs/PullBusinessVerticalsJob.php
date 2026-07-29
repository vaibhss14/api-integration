<?php

namespace App\Jobs;

use App\Models\BusinessVertical;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullBusinessVerticalsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Maximum number of seconds the job can run.
     */
    public int $timeout = 120;

    /**
     * Delay before retrying the job.
     */
    public function backoff(): array
    {
        return [60, 300, 600];
    }

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::acceptJson()
            ->timeout(120)
            ->retry(3, 3000, throw: false)
            ->withHeaders([
                'access-token' => config('services.supplier_api.access_token'),
            ])
            ->get(
                config('services.supplier_api.base_url') . '/support/business-verticals'
            );

        if (! $response->successful()) {
            logger()->error('Failed to fetch business verticals.');

            return;
        }

        $businessVerticals = $response->json('data');

        if (empty($businessVerticals)) {
            logger()->warning('No business verticals found.');

            return;
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

        logger()->info('Business verticals synchronized successfully.');
    }
}