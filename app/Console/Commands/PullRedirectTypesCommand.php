<?php

namespace App\Console\Commands;

use App\Jobs\PullRedirectTypesJob;
use Illuminate\Console\Command;

class PullRedirectTypesCommand extends Command
{
    protected $signature = 'redirect-types:pull';

    protected $description = 'Dispatch Redirect Types synchronization job';

    public function handle()
    {
        PullRedirectTypesJob::dispatch();

        $this->info('Redirect Types synchronization job dispatched.');

        return Command::SUCCESS;
    }
}