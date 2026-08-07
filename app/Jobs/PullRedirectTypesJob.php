<?php

namespace App\Jobs;

use App\Models\RedirectType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullRedirectTypesJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 120;

    public function backoff(): array
    {
        return [10, 20, 30];
    }

    public function failed(Throwable $exception): void
    {
        logger()->error('Failed to fetch redirect types.', [
            'exception' => $exception->getMessage(),
        ]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger()->info('Redirect types synchronize Started.');

        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => config('services.supplier_api.access_token'),
            ])
            ->get(
                config('services.supplier_api.base_url')
                .'/support/redirect-types'
            );

        $response->throw();

        // if (! $response->successful()) {

        //    logger()->error('Failed to fetch redirect types.');
        //    return;
        // }

        $redirectTypes = $response->json('data');

        if (empty($redirectTypes)) {

            logger()->warning('No redirect types found.');

            return;
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

        logger()->info(
            count($redirectTypes).' redirect types synchronized successfully.'
        );
    }
}
