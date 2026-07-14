<?php

namespace App\Console\Commands;

use App\Models\Survey;
use App\Models\SurveyGroup;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullSurveyGroupsCommand extends Command
{
    protected $signature = 'survey-groups:pull';

    protected $description = 'Pull Survey Groups';

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
                        "https://stagingsupply.opinionest.com/api/v1/survey/survey-groups/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                $this->warn("Timeout Survey {$survey->survey_id}");

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

            foreach ($response->json('surveyGroups') as $group) {

                foreach ($group['groupedSurveys'] as $groupedSurvey) {

                    foreach ($group['returnRestrictionStatusId'] as $statusId) {

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

        $this->newLine();

        $this->info('Survey Groups imported successfully.');

        $this->info("Surveys processed: {$processed}");

        $this->warn("Surveys skipped: {$skipped}");

        return Command::SUCCESS;
    }
}
