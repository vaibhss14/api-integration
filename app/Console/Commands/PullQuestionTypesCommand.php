<?php

namespace App\Console\Commands;

use App\Models\QuestionType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullQuestionTypesCommand extends Command
{
    protected $signature = 'question-types:pull';

    protected $description = 'Pull question types from API';

    public function handle()
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => trim(env('ACCESS_TOKEN')),
            ])
            ->get('https://stagingsupply.opinionest.com/api/v1/support/question-types');

        if (! $response->successful()) {
            $this->error('Failed to fetch question types.');

            return Command::FAILURE;
        }

        $questionTypes = $response->json('data');

        if (empty($questionTypes)) {
            $this->error('No question types found.');

            return Command::FAILURE;
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

        $this->info(count($questionTypes).' question types imported successfully.');

        return Command::SUCCESS;
    }
}
