<?php

namespace App\Console\Commands;

use App\Jobs\PullSupplierBlockedIpAddressesJob;
use Illuminate\Console\Command;

class PullSupplierBlockedIpAddressesCommand extends Command
{
    protected $signature = 'supplier-blocked-ip-addresses:pull';

    protected $description = 'Dispatch Supplier Blocked IP Addresses synchronization job';

    public function handle()
    {
        PullSupplierBlockedIpAddressesJob::dispatch();

        $this->info('Supplier Blocked IP Addresses synchronization job dispatched.');

        return Command::SUCCESS;
    }
}