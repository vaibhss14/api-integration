<?php

namespace App\Console\Commands;

use App\Models\SupplierBlockedRespondent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullSupplierBlockedRespondentsCommand extends Command
{
    protected $signature = 'supplier-blocked-respondents:pull';

    protected $description = 'Pull Supplier Blocked Respondents';

    public function handle()
    {
        $processed = 0;

        $response = Http::acceptJson()
            ->timeout(120)
            ->retry(3, 3000, throw: false)
            ->withHeaders([
                'access-token' => trim(env('ACCESS_TOKEN')),
            ])
            ->get(
                env('API_BASE_URL').'/supplier/supplier-blocked-respondents'
            );

        // Handle "No blocked supplier respondent found"
        if (
            $response->status() === 404 &&
            str_contains(
                $response->json('result.Message', ''),
                'No blocked supplier respondent found'
            )
        ) {

            $this->warn('No blocked supplier respondents found.');

            return Command::SUCCESS;
        }

        if (
            ! $response->successful() ||
            ! $response->json('result.Success')
        ) {

            $this->error('Failed to fetch supplier blocked respondents.');

            return Command::FAILURE;
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

        $this->newLine();

        $this->info('Supplier Blocked Respondents imported successfully.');

        $this->info("Records imported: {$processed}");

        return Command::SUCCESS;
    }
}
