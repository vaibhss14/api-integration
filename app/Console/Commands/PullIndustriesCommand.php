<?php

namespace App\Console\Commands;

use App\Jobs\PullIndustriesJob;
use Illuminate\Console\Command;

class PullIndustriesCommand extends Command
{
    protected $signature = 'industries:pull';

    protected $description = 'Dispatch industries synchronization job';

    public function handle()
    {
        PullIndustriesJob::dispatch();

        $this->info('Industries synchronization job dispatched.');

        return Command::SUCCESS;
    }
}