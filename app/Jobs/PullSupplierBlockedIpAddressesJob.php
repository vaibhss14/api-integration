<?php

namespace App\Jobs;

use App\Models\SupplierBlockedIpAddress;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullSupplierBlockedIpAddressesJob implements ShouldQueue
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
                .'/supplier/supplier-blocked-ip-address'
            );

        // Handle "No blocked supplier IP found"
        if (
            $response->status() === 404 &&
            str_contains(
                $response->json('result.Message', ''),
                'No blocked supplier IP found'
            )
        ) {

            logger()->warning('No blocked supplier IPs found.');

            return;
        }

        if (
            ! $response->successful() ||
            ! $response->json('result.Success')
        ) {

            logger()->error('Failed to fetch supplier blocked IPs.');

            return;
        }

        foreach ($response->json('blockedIPList') as $ip) {

            SupplierBlockedIpAddress::updateOrCreate(
                [
                    'ip_address' => $ip['ipAddress'],
                ],
                [
                    'completed_surveys' => $ip['completedSurveys'],
                    'reconcile_rate' => $ip['reconcileRate'],
                    'updated_timestamp' => ! empty($ip['updatedTimeStamp'])
                        ? Carbon::parse($ip['updatedTimeStamp'])
                        : null,
                ]
            );

            $processed++;
        }

        logger()->info('Supplier Blocked IP Addresses synchronized successfully.');
        logger()->info("Records imported: {$processed}");
    }
}
