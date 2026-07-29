<?php

namespace App\Console\Commands;

use App\Jobs\PullSurveyStatusesJob;
use Illuminate\Console\Command;

class PullSurveyStatusesCommand extends Command
{
    protected $signature = 'survey-statuses:pull';

    protected $description = 'Dispatch Survey Statuses synchronization job';

    public function handle()
    {
        PullSurveyStatusesJob::dispatch();

        $this->info('Survey Statuses synchronization job dispatched.');

        return Command::SUCCESS;
    }
}