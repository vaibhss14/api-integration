<?php

namespace App\Jobs;

use App\Models\Survey;
use App\Models\SurveyQualification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullSurveyQualificationsJob implements ShouldQueue
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
                        . "/survey/survey-Qualifications/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                logger()->warning("Timeout for Survey {$survey->survey_id}");

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

            $qualifications = $response->json('surveyQualifications');

            if (empty($qualifications)) {
                continue;
            }

            foreach ($qualifications as $qualification) {

                if (empty($qualification['answerIds'])) {
                    continue;
                }

                foreach ($qualification['answerIds'] as $answerId) {

                    $answerIds = str_contains($answerId, ',')
                        ? explode(',', $answerId)
                        : [$answerId];

                    foreach ($answerIds as $id) {

                        SurveyQualification::updateOrCreate(
                            [
                                'survey_id'        => $survey->survey_id,
                                'qualification_id' => $qualification['qualificationId'],
                                'answer_id'        => trim($id),
                            ],
                            [
                                'update_timestamp' => ! empty($qualification['updateTimeStamp'])
                                    ? Carbon::parse($qualification['updateTimeStamp'])
                                    : null,
                            ]
                        );
                    }
                }
            }

            $processed++;
        }

        logger()->info('Survey Qualifications synchronized successfully.');
        logger()->info("Surveys processed: {$processed}");
        logger()->info("Surveys skipped: {$skipped}");
    }
}