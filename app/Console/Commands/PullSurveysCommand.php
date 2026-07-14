<?php

namespace App\Console\Commands;

use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullSurveysCommand extends Command
{
    protected $signature = 'surveys:pull';

    protected $description = 'Pull surveys from API';

    public function handle()
    {
        $processed = 0;
        $skipped = 0;

        try {

            $response = Http::acceptJson()
                ->timeout(120)
                ->retry(3, 3000, throw: false)
                ->withHeaders([
                    'access-token' => trim(env('ACCESS_TOKEN')),
                ])
                ->get('https://stagingsupply.opinionest.com/api/v1/survey/surveys');

        } catch (ConnectionException $e) {

            $this->error('Connection timeout while fetching surveys.');

            return Command::FAILURE;
        }

        if (
            $response->status() === 404 ||
            ! $response->successful() ||
            ! $response->json('result.Success')
        ) {

            $this->error('Failed to fetch surveys.');

            return Command::FAILURE;
        }

        $surveys = $response->json('surveys');

        if (empty($surveys)) {

            $this->warn('No surveys found.');

            return Command::SUCCESS;
        }

        foreach ($surveys as $survey) {

            Survey::updateOrCreate(

                [
                    'survey_id' => $survey['SurveyId'],
                ],

                [
                    'survey_name' => $survey['SurveyName'],

                    'industry_id' => $survey['IndustryId'],
                    'country_id' => $survey['CountryId'],
                    'study_type_id' => $survey['StudyTypeId'],

                    'cpi' => $survey['Cpi'],
                    'loi' => $survey['Loi'],
                    'ir' => $survey['Ir'],

                    'collect_pii' => $survey['CollectPII'],

                    'is_mobile' => $survey['IsMobile'],
                    'is_tablet' => $survey['IsTablet'],
                    'is_desktop' => $survey['IsDesktop'],

                    'is_survey_group_exist' => $survey['isSurveyGroupExist'],

                    'client_id' => $survey['ClientId'],
                    'account_id' => $survey['AccountId'],

                    'live_link' => $survey['LiveLink'],
                    'test_link' => $survey['TestLink'],

                    'update_timestamp' => ! empty($survey['UpdateTimeStamp'])
                        ? Carbon::parse($survey['UpdateTimeStamp'])
                        : null,

                    'qual_update_timestamp' => ! empty($survey['Qual_UpdateTimeStamp'])
                        ? Carbon::parse($survey['Qual_UpdateTimeStamp'])
                        : null,

                    'quota_update_timestamp' => ! empty($survey['Quota_UpdateTimeStamp'])
                        ? Carbon::parse($survey['Quota_UpdateTimeStamp'])
                        : null,

                    'group_update_timestamp' => ! empty($survey['Group_UpdateTimeStamp'])
                        ? Carbon::parse($survey['Group_UpdateTimeStamp'])
    : null,
                ]
            );

            $processed++;
        }

        $this->newLine();

        $this->info('Surveys imported successfully.');
        $this->info("Total Surveys Imported: {$processed}");
        $this->warn("Surveys Skipped: {$skipped}");

        return Command::SUCCESS;
    }
}
