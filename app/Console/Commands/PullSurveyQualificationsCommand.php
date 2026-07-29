<?php

namespace App\Console\Commands;

use App\Jobs\PullSurveyQualificationsJob;
use Illuminate\Console\Command;

class PullSurveyQualificationsCommand extends Command
{
    protected $signature = 'survey-qualifications:pull';

    protected $description = 'Dispatch Survey Qualifications synchronization job';

    public function handle()
    {
        PullSurveyQualificationsJob::dispatch();

        $this->info('Survey Qualifications synchronization job dispatched.');

        return Command::SUCCESS;
    }
}