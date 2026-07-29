<?php

namespace App\Console\Commands;

use App\Jobs\PullSurveyQuotasJob;
use Illuminate\Console\Command;

class PullSurveyQuotasCommand extends Command
{
    protected $signature = 'survey-quotas:pull';

    protected $description = 'Dispatch Survey Quotas synchronization job';

    public function handle()
    {
        PullSurveyQuotasJob::dispatch();

        $this->info('Survey Quotas synchronization job dispatched.');

        return Command::SUCCESS;
    }
}
