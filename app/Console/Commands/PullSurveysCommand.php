<?php

namespace App\Console\Commands;

use App\Jobs\PullSurveysJob;
use Illuminate\Console\Command;

class PullSurveysCommand extends Command
{
    protected $signature = 'surveys:pull';

    protected $description = 'Dispatch Surveys synchronization job';

    public function handle()
    {
        PullSurveysJob::dispatch();

        $this->info('Surveys synchronization job dispatched.');

        return Command::SUCCESS;
    }
}
