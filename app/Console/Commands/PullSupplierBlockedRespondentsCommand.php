<?php

namespace App\Console\Commands;

use App\Jobs\PullSupplierBlockedRespondentsJob;
use Illuminate\Console\Command;

class PullSupplierBlockedRespondentsCommand extends Command
{
    protected $signature = 'supplier-blocked-respondents:pull';

    protected $description = 'Dispatch Supplier Blocked Respondents synchronization job';

    public function handle()
    {
        PullSupplierBlockedRespondentsJob::dispatch();

        $this->info('Supplier Blocked Respondents synchronization job dispatched.');

        return Command::SUCCESS;
    }
}
