<?php

namespace App\Jobs;

use App\Models\Country;
use App\Models\Question;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Throwable;

class PullQuestionsJob implements ShouldQueue
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
        logger()->error('Failed to fetch questions.', [
            'exception' => $exception->getMessage(),
        ]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger()->info('Questions synchronize Started.');

        $processed = 0;
        $skipped = 0;

        Country::orderBy('id')
            ->chunkById(20, function ($countries) use (&$processed, &$skipped) {

                foreach ($countries as $country) {

                    try {

                        $response = Http::acceptJson()
                            // ->timeout(120)
                            // ->retry(3, 3000, throw: false)
                            ->withHeaders([
                                'access-token' => config('services.supplier_api.access_token'),
                            ])
                            ->get(
                                config('services.supplier_api.base_url')
                                ."/support/question/{$country->country_id}"
                            );

                        $response->throw();
                    } catch (ConnectionException $e) {

                        logger()->warning("Timeout for {$country->country_name}");

                        $skipped++;

                        continue;

                    } catch (Throwable $e) {

                        logger()->error(
                            "Error processing {$country->country_name}: {$e->getMessage()}"
                        );

                        $skipped++;

                        continue;
                    }

                    if (
                        $response->status() === 404 &&
                        $response->json('message') === 'No active questions found'
                    ) {

                        logger()->warning(
                            "Skipped {$country->country_name} ({$country->localization_code}) - No active questions."
                        );

                        $skipped++;

                        continue;
                    }

                    // if (! $response->successful()) {

                    //    logger()->warning(
                    //        "HTTP {$response->status()} for {$country->country_name}"
                    //    );

                    //    $skipped++;
                    //    continue;
                    // }

                    $questions = $response->json('data', []);

                    if (empty($questions)) {

                        logger()->warning(
                            "No questions for {$country->country_name}"
                        );

                        continue;
                    }

                    foreach ($questions as $question) {

                        Question::updateOrCreate(
                            [
                                'question_id' => $question['QuestionId'],
                                'country_id' => $country->country_id,
                            ],
                            [
                                'description' => $question['Description'],
                                'question_category_id' => $question['QuestionCategoryId'] ?? null,
                                'question_type_id' => $question['QuestionTypeId'] ?? null,
                                'localization_code' => $question['localizationCode'],
                            ]
                        );
                    }

                    logger()->info(
                        count($questions)." questions saved for {$country->country_name}"
                    );

                    $processed++;
                }
            });

        logger()->info('Questions synchronized successfully.');
        logger()->info("Countries processed: {$processed}");
        logger()->info("Countries skipped: {$skipped}");
    }
}
