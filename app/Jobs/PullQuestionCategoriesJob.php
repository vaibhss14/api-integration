<?php

namespace App\Jobs;

use App\Models\QuestionCategory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Throwable;

class PullQuestionCategoriesJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 120;

    public function backoff(): array
    {
        return [10, 20, 30];
    }

    public function failed(Throwable $exception): void
    {
        logger()->error('Failed to fetch question categories.', [
            'exception' => $exception->getMessage(),
        ]);
    }

    public function handle(): void
    {
        logger ()->info('Question categories synchronize Started.');

        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => config('services.supplier_api.access_token'),
            ])
            ->get(
                config('services.supplier_api.base_url')
                .'/support/question-categories'
            );

        $response->throw();
        //if (! $response->successful()) {
        //    logger()->error('Failed to fetch question categories.');

        //    return;
        //}

        $questionCategories = $response->json('data');

        if (empty($questionCategories)) {
            logger()->warning('No question categories found.');

            return;
        }

        foreach ($questionCategories as $category) {

            QuestionCategory::updateOrCreate(
                [
                    'category_id' => $category['categoryId'],
                ],
                [
                    'category_name' => trim($category['categoryName']),
                ]
            );
        }

        logger()->info('Question Categories synchronized successfully.');
    }
}
