<?php

namespace App\Jobs;

use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Throwable;

class PullSurveysJob implements ShouldQueue
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
        logger()->error('Failed to fetch surveys.', [
            'exception' => $exception->getMessage(),
        ]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger()->info('Surveys synchronize Started.');

        $processed = 0;
        $skipped = 0;

        try {

            $response = Http::acceptJson()
                // ->timeout(120)
                // ->retry(3, 3000, throw: false)
                ->withHeaders([
                    'access-token' => config('services.supplier_api.access_token'),
                ])
                ->get(
                    config('services.supplier_api.base_url')
                    .'/survey/surveys'
                );

        } catch (ConnectionException $e) {

            logger()->error('Connection timeout while fetching surveys.');

            return;
        }

        $response->throw();

        if (
            $response->status() === 404 ||
            ! $response->successful() ||
            ! $response->json('result.Success')
        ) {

            logger()->error('Failed to fetch surveys.');

            return;
        }

        $surveys = $response->json('surveys');

        if (empty($surveys)) {

            logger()->warning('No surveys found.');

            return;
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

        logger()->info('Surveys synchronized successfully.');
        logger()->info("Total Surveys Imported: {$processed}");
        logger()->info("Surveys Skipped: {$skipped}");
    }
}
