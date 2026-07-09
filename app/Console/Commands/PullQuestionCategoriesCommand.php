<?php

namespace App\Console\Commands;

use App\Models\QuestionCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullQuestionCategoriesCommand extends Command
{
    protected $signature = 'question-categories:pull';

    protected $description = 'Pull question categories from API';

    public function handle()
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => trim(env('ACCESS_TOKEN')),
            ])
            ->get('https://stagingsupply.opinionest.com/api/v1/support/question-categories');

        if (! $response->successful()) {
            $this->error('Failed to fetch question categories.');

            return Command::FAILURE;
        }

        $questionCategories = $response->json('data');

        if (empty($questionCategories)) {
            $this->error('No question categories found.');

            return Command::FAILURE;
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

        $this->info(count($questionCategories).' question categories imported successfully.');

        return Command::SUCCESS;
    }
}