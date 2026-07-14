<?php

namespace App\Console\Commands;

use App\Models\SupplierBlockedIpAddress;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullSupplierBlockedIpAddressesCommand extends Command
{
    protected $signature = 'supplier-blocked-ip-addresses:pull';

    protected $description = 'Pull Supplier Blocked IP Addresses';

    public function handle()
    {
        $processed = 0;
        $skipped = 0;

        $response = Http::acceptJson()
            ->timeout(120)
            ->retry(3, 3000, throw: false)
            ->withHeaders([
                'access-token' => trim(env('ACCESS_TOKEN')),
            ])
            ->get(
                'https://stagingsupply.opinionest.com/api/v1/supplier/supplier-blocked-ip-address'
            );

        // Handle "No blocked supplier IP found"
        if (
            $response->status() === 404 &&
            str_contains(
                $response->json('result.Message', ''),
                'No blocked supplier IP found'
            )
        ) {

            $this->warn('No blocked supplier IPs found.');

            return Command::SUCCESS;
        }

        if (
            ! $response->successful() ||
            ! $response->json('result.Success')
        ) {

            $this->error('Failed to fetch supplier blocked IPs.');

            return Command::FAILURE;
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

        $this->newLine();

        $this->info('Supplier Blocked IP Addresses imported successfully.');

        $this->info("Records imported: {$processed}");

        return Command::SUCCESS;
    }
}
