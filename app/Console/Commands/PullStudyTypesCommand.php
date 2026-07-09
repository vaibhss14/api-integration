<?php

namespace App\Console\Commands;

use App\Models\StudyType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullStudyTypesCommand extends Command
{
    protected $signature = 'study-types:pull';

    protected $description = 'Pull study types from API and store them';

    public function handle()
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'access-token' => trim(env('ACCESS_TOKEN')),
            ])
            ->get('https://stagingsupply.opinionest.com/api/v1/support/study-types');

        if (! $response->successful()) {
            $this->error('Failed to fetch study types.');

            return Command::FAILURE;
        }

        $studyTypes = $response->json('data');

        if (empty($studyTypes)) {
            $this->error('No study types found.');

            return Command::FAILURE;
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

        $this->info(count($studyTypes) . ' study types imported successfully.');

        return Command::SUCCESS;
    }
}