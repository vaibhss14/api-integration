<?php

namespace App\Jobs;

use App\Models\Survey;
use App\Models\SurveyQuota;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Throwable;

class PullSurveyQuotasJob implements ShouldQueue
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
        logger()->error('Failed to fetch survey quotas.', [
            'exception' => $exception->getMessage(),
        ]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger()->info('Survey Quotas synchronize Started.');

        $processed = 0;
        $skipped = 0;

        $surveys = Survey::all();

        foreach ($surveys as $survey) {

            try {

                $response = Http::acceptJson()
                    ->withHeaders([
                        'access-token' => config('services.supplier_api.access_token'),
                    ])
                    ->get(
                        config('services.supplier_api.base_url')
                        ."/survey/survey-quotas/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                logger()->warning("Timeout Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            // Handle "No survey quotas found"
            if (
                $response->status() === 404 &&
                str_contains(
                    $response->json('result.Message', ''),
                    'No survey quotas found'
                )
            ) {
                logger()->warning("No survey quotas found for Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            // Throw only for unexpected HTTP errors
            $response->throw();

            if (! $response->json('result.Success')) {

                logger()->warning("Skipped Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            foreach ($response->json('surveyQuotas', []) as $quota) {

                foreach ($quota['criteria'] ?? [] as $criteria) {

                    foreach ($criteria['answerIds'] ?? [] as $answerId) {

                        SurveyQuota::updateOrCreate(
                            [
                                'survey_id' => $survey->survey_id,
                                'quota_id' => $quota['quotaId'],
                                'qualification_id' => $criteria['qualificationId'],
                                'answer_id' => $answerId,
                            ],
                            [
                                'quota_name' => $quota['quotaName'],
                                'total_remaining' => $quota['totalRemaining'],
                                'update_timestamp' => ! empty($quota['updateTimeStamp'])
                                    ? Carbon::parse($quota['updateTimeStamp'])
                                    : null,
                            ]
                        );
                    }
                }
            }

            $processed++;
        }

        logger()->info('Survey Quotas synchronized successfully.');
        logger()->info("Surveys processed: {$processed}");
        logger()->info("Surveys skipped: {$skipped}");
    }
}
