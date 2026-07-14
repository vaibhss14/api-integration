<?php

namespace App\Console\Commands;

use App\Models\Survey;
use App\Models\SurveyQuota;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullSurveyQuotasCommand extends Command
{
    protected $signature = 'survey-quotas:pull';

    protected $description = 'Pull survey quotas';

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
                        "https://stagingsupply.opinionest.com/api/v1/survey/survey-quotas/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                $this->warn("Timeout {$survey->survey_id}");

                $skipped++;

                continue;
            }

            if (
                ! $response->successful() ||
                ! $response->json('result.Success')
            ) {

                $this->warn("Skipped {$survey->survey_id}");

                $skipped++;

                continue;
            }

            foreach ($response->json('surveyQuotas') as $quota) {

                foreach ($quota['criteria'] as $criteria) {

                    foreach ($criteria['answerIds'] as $answerId) {

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

        $this->newLine();

        $this->info('Survey Quotas imported successfully.');

        $this->info("Surveys processed: {$processed}");

        $this->warn("Surveys skipped: {$skipped}");

        return Command::SUCCESS;
    }
}
