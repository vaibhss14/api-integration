<?php

namespace App\Jobs;

use App\Models\Survey;
use App\Models\SurveyGroup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullSurveyGroupsJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 1800;

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
        $skipped = 0;

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
                        ."/survey/survey-groups/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                logger()->warning("Timeout Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            if (
                ! $response->successful() ||
                ! $response->json('result.Success')
            ) {

                logger()->warning("Skipped Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            foreach ($response->json('surveyGroups', []) as $group) {

                foreach ($group['groupedSurveys'] ?? [] as $groupedSurvey) {

                    foreach ($group['returnRestrictionStatusId'] ?? [] as $statusId) {

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
