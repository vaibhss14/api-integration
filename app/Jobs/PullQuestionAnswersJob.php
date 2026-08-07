<?php

namespace App\Jobs;

use App\Models\Country;
use App\Models\QuestionAnswer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullQuestionAnswersJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 3600;

    public function backoff(): array
    {
        return [10, 20, 30];
    }

    public function failed(Throwable $exception): void
    {
        logger()->error('Failed to fetch question answers.', [
            'exception' => $exception->getMessage(),
        ]);
    }

    public function handle(): void
    {
        Country::orderBy('id')
            ->chunkById(20, function ($countries) {

                foreach ($countries as $country) {

                    try {

                        logger()->info("Started {$country->country_name}");
                        $response = Http::acceptJson()
                            // ->timeout(3600)
                            // ->retry(3, 3000, throw: false)
                            ->withHeaders([
                                'access-token' => config('services.supplier_api.access_token'),
                            ])
                            ->get(
                                config('services.supplier_api.base_url')
                                ."/support/question-answers/country/{$country->country_id}"
                            );

                        $response->throw();
                    } catch (ConnectionException $e) {

                        logger()->warning("Timeout for {$country->country_name}");

                        continue;
                    }

                    if (
                        $response->status() === 404 ||
                        ! $response->successful() ||
                        ! $response->json('success')
                    ) {

                        logger()->warning("Skipped {$country->country_name}");

                        continue;
                    }

                    $questions = $response->json('data', []);

                    foreach ($questions as $question) {

                        foreach ($question['QuestionAnswers'] ?? [] as $answer) {

                            QuestionAnswer::updateOrCreate(
                                [
                                    'answer_id' => $answer['AnswerId'],
                                    'question_id' => $question['QuestionId'],
                                ],
                                [
                                    'country_id' => $country->country_id,
                                    'localization_code' => $question['localizationCode'],
                                    'description' => $answer['Description'],
                                ]
                            );
                        }
                    }

                    unset($questions);
                    unset($response);

                    gc_collect_cycles();

                    logger()->info("Completed {$country->country_name}");
                }
            });

        logger()->info('Question Answers synchronized successfully.');
    }
}
