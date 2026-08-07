<?php

namespace App\Jobs;

use App\Models\Survey;
use App\Models\SurveyGroup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Throwable;

class PullSurveyGroupsJob implements ShouldQueue
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
        logger()->error('Failed to fetch survey groups.', [
            'exception' => $exception->getMessage(),
        ]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger()->info('Survey groups synchronize Started.');

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
                        ."/survey/survey-groups/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                logger()->warning("Timeout for Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            // Skip surveys that have no survey groups
            if (
                $response->status() === 404 &&
                str_contains(
                    $response->json('result.Message', ''),
                    'No survey group found'
                )
            ) {
                logger()->warning("No survey groups found for Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            // Throw exception for other unexpected HTTP errors
            $response->throw();

            // Skip unsuccessful responses
            if (! $response->json('result.Success')) {

                logger()->warning("Skipped Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            foreach ($response->json('surveyGroups', []) as $group) {

                $groupedSurveys = $group['groupedSurveys'] ?? [];

                $statusIds = is_array($group['returnRestrictionStatusId'] ?? null)
                    ? $group['returnRestrictionStatusId']
                    : [$group['returnRestrictionStatusId'] ?? null];

                foreach ($groupedSurveys as $groupedSurvey) {

                    foreach ($statusIds as $statusId) {

                        SurveyGroup::updateOrCreate(
                            [
                                'survey_id' => $survey->survey_id,
                                'survey_group_id' => $group['surveyGroupId'],
                                'grouped_survey_id' => $groupedSurvey,
                                'return_restriction_status_id' => $statusId,
                            ],
                            [
                                'survey_group_name' => $group['surveyGroupName'],
                            ]
                        );
                    }
                }
            }

            $processed++;
        }

        logger()->info('Survey Groups synchronized successfully.');
        logger()->info("Surveys processed: {$processed}");
        logger()->info("Surveys skipped: {$skipped}");
    }
}
