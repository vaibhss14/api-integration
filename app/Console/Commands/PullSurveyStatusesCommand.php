<?php

namespace App\Console\Commands;

use App\Models\SurveyStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullSurveyStatusesCommand extends Command
{
    protected $signature = 'survey-statuses:pull';

    protected $description = 'Pull survey statuses from API and store them';

    public function handle()
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => trim(env('ACCESS_TOKEN')),
            ])
            ->get(env('API_BASE_URL').'/support/survey-status');

        if (! $response->successful()) {
            $this->error('Failed to fetch survey statuses.');

            return Command::FAILURE;
        }

        $surveyStatuses = $response->json('data');

        if (empty($surveyStatuses)) {
            $this->error('No survey statuses found.');

            return Command::FAILURE;
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

        $this->info(count($surveyStatuses).' survey statuses imported successfully.');

        return Command::SUCCESS;
    }
}
