<?php

namespace App\Jobs;

use App\Models\Survey;
use App\Models\SurveyBlockedIpAddress;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Throwable;

class PullSurveyBlockedIpAddressesJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 1800;

    public function backoff(): array
    {
        return [10, 20, 30];
    }

    public function failed(Throwable $exception): void
    {
        logger()->error('Failed to fetch survey blocked IP addresses.', [
            'exception' => $exception->getMessage(),
        ]);
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $processed = 0;
        $skipped = 0;

        $surveys = Survey::all();

        foreach ($surveys as $survey) {

            try {

            logger()->info("Fetching blocked IPs for Survey {$survey->survey_id}");
            
                $response = Http::acceptJson()
                    //->timeout(120)
                    //->retry(3, 3000, throw: false)
                    ->withHeaders([
                        'access-token' => config('services.supplier_api.access_token'),
                    ])
                    ->get(
                        config('services.supplier_api.base_url')
                        ."/survey/survey-blocked-ip-address/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                logger()->warning("Timeout Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            if (
                $response->status() === 404 &&
                $response->json('result.Message') &&
                str_contains(
                    $response->json('result.Message'),
                    'No blocked IPs found'
                )
            ) {

                logger()->warning(
                    "No blocked IPs for Survey {$survey->survey_id}"
                );

                $skipped++;

                continue;
            }

            $response->throw();

            if (
                ! $response->successful() ||
                ! $response->json('result.Success')
            ) {

                logger()->warning(
                    "Skipped Survey {$survey->survey_id}"
                );

                $skipped++;

                continue;
            }

            $ips = $response->json('ipAddress');

            if (empty($ips)) {
                continue;
            }

            foreach ($ips as $ip) {

                SurveyBlockedIpAddress::updateOrCreate(
                    [
                        'survey_id' => $survey->survey_id,
                        'ip_address' => $ip,
                    ],
                    [
                        'update_timestamp' => ! empty($response->json('updateTimestamp'))
                            ? Carbon::parse($response->json('updateTimestamp'))
                            : null,
                    ]
                );
            }

            $processed++;
        }

        logger()->info('Survey Blocked IP Addresses synchronized successfully.');
        logger()->info("Surveys processed: {$processed}");
        logger()->info("Surveys skipped: {$skipped}");
    }
}
