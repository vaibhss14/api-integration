<?php

namespace App\Console\Commands;

use App\Jobs\PullReturnStatusesJob;
use Illuminate\Console\Command;

class PullReturnStatusesCommand extends Command
{
    protected $signature = 'return-statuses:pull';

    protected $description = 'Dispatch Return Statuses synchronization job';

    public function handle()
    {
        PullReturnStatusesJob::dispatch();

        $this->info('Return Statuses synchronization job dispatched.');

        return Command::SUCCESS;
    }
}