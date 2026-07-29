<?php

namespace App\Jobs;

use App\Models\SurveyStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullSurveyStatusesJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 120;

    public function backoff(): array
    {
        return [60, 300, 600];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => config('services.supplier_api.access_token'),
            ])
            ->get(
                config('services.supplier_api.base_url')
                . '/support/survey-status'
            );

        if (! $response->successful()) {

            logger()->error('Failed to fetch survey statuses.');

            return;
        }

        $surveyStatuses = $response->json('data');

        if (empty($surveyStatuses)) {

            logger()->warning('No survey statuses found.');

            return;
        }

        foreach ($surveyStatuses as $status) {

            SurveyStatus::updateOrCreate(
                [
                    'survey_status_id' => $status['SurveyStatusId'],
                ],
                [
                    'status_name' => trim($status['statusName']),
                ]
            );
        }

        logger()->info(
            count($surveyStatuses) . ' survey statuses synchronized successfully.'
        );
    }
}