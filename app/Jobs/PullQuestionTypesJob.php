<?php

namespace App\Jobs;

use App\Models\QuestionType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullQuestionTypesJob implements ShouldQueue
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
                .'/support/question-types'
            );

        if (! $response->successful()) {

            logger()->error('Failed to fetch question types.');

            return;
        }

        $questionTypes = $response->json('data');

        if (empty($questionTypes)) {

            logger()->warning('No question types found.');

            return;
        }

        foreach ($questionTypes as $questionType) {

            QuestionType::updateOrCreate(
                [
                    'question_type_id' => $questionType['QuestionTypeId'],
                ],
                [
                    'question_type_name' => trim($questionType['QuestionTypeName']),
                ]
            );
        }

        logger()->info('Question Types synchronized successfully.');
    }
}
