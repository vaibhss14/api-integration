<?php

namespace App\Console\Commands;

use App\Jobs\PullStudyTypesJob;
use Illuminate\Console\Command;

class PullStudyTypesCommand extends Command
{
    protected $signature = 'study-types:pull';

    protected $description = 'Dispatch Study Types synchronization job';

    public function handle()
    {
        PullStudyTypesJob::dispatch();

        $this->info('Study Types synchronization job dispatched.');

        return Command::SUCCESS;
    }
}
