<?php

namespace App\Console\Commands;

use App\Jobs\PullQuestionsJob;
use Illuminate\Console\Command;

class PullQuestionsCommand extends Command
{
    protected $signature = 'questions:pull';

    protected $description = 'Dispatch Questions synchronization job';

    public function handle()
    {
        PullQuestionsJob::dispatch();

        $this->info('Questions synchronization job dispatched.');

        return Command::SUCCESS;
    }
}