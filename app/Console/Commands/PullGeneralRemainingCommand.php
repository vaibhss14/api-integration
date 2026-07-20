<?php

namespace App\Console\Commands;

use App\Models\GeneralRemaining;
use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullGeneralRemainingCommand extends Command
{
    protected $signature = 'general-remaining:pull';

    protected $description = 'Pull General Remaining data';

    public function handle()
    {
        $processed = 0;
        $skipped = 0;

        $surveys = Survey::all();

        foreach ($surveys as $survey) {

            $this->info("Fetching Survey {$survey->survey_id}");

            try {

                $response = Http::acceptJson()
                    ->timeout(120)
                    ->retry(3, 3000, throw: false)
                    ->withHeaders([
                        'access-token' => trim(env('ACCESS_TOKEN')),
                    ])
                    ->get(
                        env('API_BASE_URL')."/survey/general-reserved-remaining/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                $this->warn("Timeout Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            if (
                $response->status() === 404
            ) {

                $this->warn("No remaining data for Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            if (
                ! $response->successful() ||
                ! $response->json('result.Success')
            ) {

                $this->warn("Skipped Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            $remaining = $response->json('totalRemainaing');

            GeneralRemaining::updateOrCreate(

                [
                    'survey_id' => $survey->survey_id,
                ],

                [
                    'total_remaining' => $remaining['TotalRemaining'],

                    'total_reserved_remaining' => $remaining['TotalReservedRemaining'],

                    'reservation_expiration' => ! empty($remaining['ReservationExpiration'])
                            ? Carbon::parse($remaining['ReservationExpiration'])
                            : null,
                ]

            );

            $processed++;
        }

        $this->newLine();

        $this->info('General Remaining imported successfully.');

        $this->info("Surveys processed: {$processed}");

        $this->warn("Surveys skipped: {$skipped}");

        return Command::SUCCESS;
    }
}
