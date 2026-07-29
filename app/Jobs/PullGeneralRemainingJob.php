<?php

namespace App\Jobs;

use App\Models\GeneralRemaining;
use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullGeneralRemainingJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 120;

    public function backoff(): array
    {
        return [60, 300, 600];
    }

    public function handle(): void
    {
        $surveys = Survey::all();

        foreach ($surveys as $survey) {

            try {

                $response = Http::acceptJson()
                    ->timeout(120)
                    ->retry(3, 3000, throw: false)
                    ->withHeaders([
                        'access-token' => config('services.supplier_api.access_token'),
                    ])
                    ->get(
                        config('services.supplier_api.base_url')
                        ."/survey/general-reserved-remaining/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                logger()->warning("Timeout Survey {$survey->survey_id}");

                continue;
            }

            if ($response->status() === 404) {

                logger()->warning(
                    "No remaining data for Survey {$survey->survey_id}"
                );

                continue;
            }

            if (
                ! $response->successful() ||
                ! $response->json('result.Success')
            ) {

                logger()->warning(
                    "Skipped Survey {$survey->survey_id}"
                );

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
        }

        logger()->info('General Remaining synchronized successfully.');
    }
}
