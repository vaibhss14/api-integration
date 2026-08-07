<?php

namespace App\Jobs;

use App\Models\Industry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullIndustriesJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 120;

    public function backoff(): array
    {
        return [10, 20, 30];
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
        logger()->info('Industries synchronize Started.');

        $response = Http::acceptJson()
            // ->timeout(120)
            // ->retry(3, 3000, throw: false)
            ->withHeaders([
                'access-token' => config('services.supplier_api.access_token'),
            ])
            ->get(
                config('services.supplier_api.base_url').'/support/industry-list'
            );

        $response->throw();
        // if (! $response->successful()) {
        //     logger()->error('Failed to fetch industries.');

        //     return;
        // }

        $industries = $response->json('data');

        if (empty($industries)) {
            logger()->warning('No industries found.');

            return;
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
        logger()->info('Industries synchronize completed successfully.');
    }
}
