<?php

namespace App\Console\Commands;

use App\Jobs\PullSurveyGroupsJob;
use Illuminate\Console\Command;

class PullSurveyGroupsCommand extends Command
{
    protected $signature = 'survey-groups:pull';

    protected $description = 'Dispatch Survey Groups synchronization job';

    public function handle()
    {
        PullSurveyGroupsJob::dispatch();

        $this->info('Survey Groups synchronization job dispatched.');

        return Command::SUCCESS;
    }
}