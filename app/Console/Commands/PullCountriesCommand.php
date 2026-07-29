<?php

namespace App\Console\Commands;

use App\Jobs\PullCountriesJob;
use Illuminate\Console\Command;

class PullCountriesCommand extends Command
{
    protected $signature = 'countries:pull';

    protected $description = 'Dispatch the country synchronization job';

    public function handle()
    {
        PullCountriesJob::dispatch();

        $this->info('Country synchronization job dispatched.');

        return Command::SUCCESS;
    }
}
