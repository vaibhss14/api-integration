<?php

namespace App\Console\Commands;

use App\Jobs\PullBusinessVerticalsJob;
use Illuminate\Console\Command;

class PullBusinessVerticalsCommand extends Command
{
    protected $signature = 'business-verticals:pull';

    protected $description = 'Pull business verticals from API';

    public function handle()
    {
        PullBusinessVerticalsJob::dispatch();

        $this->info('Business verticals job dispatched.');

        return Command::SUCCESS;
    }
}
