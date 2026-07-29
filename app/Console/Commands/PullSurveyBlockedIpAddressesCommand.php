<?php

namespace App\Console\Commands;

use App\Jobs\PullSurveyBlockedIpAddressesJob;
use Illuminate\Console\Command;

class PullSurveyBlockedIpAddressesCommand extends Command
{
    protected $signature = 'survey-blocked-ip-addresses:pull';

    protected $description = 'Dispatch Survey Blocked IP Addresses synchronization job';

    public function handle()
    {
        PullSurveyBlockedIpAddressesJob::dispatch();

        $this->info('Survey Blocked IP Addresses synchronization job dispatched.');

        return Command::SUCCESS;
    }
}
