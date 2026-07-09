<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullQuestionsCommand extends Command
{
    protected $signature = 'questions:pull';

    protected $description = 'Pull questions for all countries';

    public function handle()
    {

        $processed = 0;
        $skipped = 0;

        $countries = Country::all();

        foreach ($countries as $country) {

            $this->info("Fetching {$country->country_name}");

            $response = Http::acceptJson()
                ->withHeaders([
                    'access-token' => trim(env('ACCESS_TOKEN')),
                ])
                ->get("https://stagingsupply.opinionest.com/api/v1/support/question/{$country->country_id}");

            if (
                    $response->status() === 404 &&
                    $response->json('message') === 'No active questions found'
                ) {

                    $this->warn(
                        "Skipped {$country->country_name} ({$country->localization_code}) - No active questions."
                    );
                    $skipped++;
                    continue;
                }

            $questions = $response->json('data');

            if (empty($questions)) {
                $this->warn("No questions for {$country->country_name}");
                
                continue;
            }

            foreach ($questions as $question) {

                Question::updateOrCreate(
                    [
                        'question_id' => $question['QuestionId'],
                    ],
                    [
                        'description' => $question['Description'],
                        'question_category_id' => $question['QuestionCategoryId'] ?? null,
                        'question_type_id' => $question['QuestionTypeId'] ?? null,
                        'localization_code' => $question['localizationCode'],
                    ]
                );
            }

            $this->info(count($questions) . " questions saved.");

            $processed++;
        }

        $this->newLine();

        $this->info("Questions imported successfully.");

        $this->info("Countries processed: {$processed}");

        $this->warn("Countries skipped (no active questions): {$skipped}");

return Command::SUCCESS;

    }
}