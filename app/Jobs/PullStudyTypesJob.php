<?php

namespace App\Jobs;

use App\Models\StudyType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullStudyTypesJob implements ShouldQueue
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
                . '/support/study-types'
            );

        if (! $response->successful()) {

            logger()->error('Failed to fetch study types.');

            return;
        }

        $studyTypes = $response->json('data');

        if (empty($studyTypes)) {

            logger()->warning('No study types found.');

            return;
        }

        foreach ($studyTypes as $studyType) {

            StudyType::updateOrCreate(
                [
                    'study_type_id' => $studyType['StudyTypeId'],
                ],
                [
                    'study_name' => trim($studyType['StudyName']),
                ]
            );
        }

        logger()->info(
            count($studyTypes) . ' study types synchronized successfully.'
        );
    }
}