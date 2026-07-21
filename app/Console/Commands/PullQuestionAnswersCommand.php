<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\QuestionAnswer;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullQuestionAnswersCommand extends Command
{
    protected $signature = 'question-answers:pull';

    protected $description = 'Pull question answers from API';

    public function handle()
    {
        $processed = 0;
        $skipped = 0;

        $countries = Country::all();

        foreach ($countries as $country) {

            $this->info("Fetching {$country->country_name} ({$country->localization_code})");

            try {

                $response = Http::acceptJson()
                    ->timeout(120)
                    ->retry(3, 3000, throw: false)
                    ->withHeaders([
                        'access-token' => trim(env('ACCESS_TOKEN')),
                    ])
                    ->get(
                        env('API_BASE_URL')."/support/question-answers/country/{$country->country_id}"
                    );

            } catch (ConnectionException $e) {

                $this->warn("Timeout for {$country->country_name}");

                $skipped++;

                continue;
            }

            if (
                $response->status() === 404 ||
                ! $response->successful() ||
                ! $response->json('success')
            ) {

                $this->warn("Skipped {$country->country_name}");

                $skipped++;

                continue;
            }

            $data = $response->json('data');

            if (empty($data)) {
                continue;
            }

            foreach ($data as $question) {

                if (empty($question['QuestionAnswers'])) {
                    continue;
                }

                foreach ($question['QuestionAnswers'] as $answer) {

                    QuestionAnswer::updateOrCreate(
                        [
                            'answer_id' => $answer['AnswerId'],
                            'question_id' => $question['QuestionId'],
                        ],
                        [
                            'localization_code' => $question['localizationCode'],
                            'description' => $answer['Description'],
                        ]
                    );
                }
            }

            $processed++;
        }

        $this->info('Question Answers imported successfully.');
        $this->info("Countries processed: {$processed}");
        $this->warn("Countries skipped: {$skipped}");

        return Command::SUCCESS;
    }
}
