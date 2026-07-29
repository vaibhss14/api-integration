<?php

namespace App\Console\Commands;

use App\Jobs\PullGeneralRemainingJob;
use Illuminate\Console\Command;

class PullGeneralRemainingCommand extends Command
{
    protected $signature = 'general-remaining:pull';

    protected $description = 'Dispatch General Remaining synchronization job';

    public function handle()
    {
        PullGeneralRemainingJob::dispatch();

        $this->info('General Remaining synchronization job dispatched.');

        return Command::SUCCESS;
    }
}
