<?php

namespace App\Console\Commands;

use App\Models\Survey;
use App\Models\SurveyQualification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullSurveyQualificationsCommand extends Command
{
    protected $signature = 'survey-qualifications:pull';

    protected $description = 'Pull survey qualifications';

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
                        env('API_BASE_URL')."/survey/survey-Qualifications/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                $this->warn("Timeout for Survey {$survey->survey_id}");

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

            $qualifications = $response->json('surveyQualifications');

            if (empty($qualifications)) {
                continue;
            }

            foreach ($qualifications as $qualification) {

                if (empty($qualification['answerIds'])) {
                    continue;
                }

                foreach ($qualification['answerIds'] as $answerId) {

                    // Handle comma-separated values returned as one string
                    $answerIds = str_contains($answerId, ',')
                        ? explode(',', $answerId)
                        : [$answerId];

                    foreach ($answerIds as $id) {

                        SurveyQualification::updateOrCreate(
                            [
                                'survey_id' => $survey->survey_id,
                                'qualification_id' => $qualification['qualificationId'],
                                'answer_id' => trim($id),
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

        $this->newLine();

        $this->info('Survey Qualifications imported successfully.');
        $this->info("Surveys processed: {$processed}");
        $this->warn("Surveys skipped: {$skipped}");

        return Command::SUCCESS;
    }
}
