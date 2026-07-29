<?php

namespace App\Console\Commands;

use App\Jobs\PullQuestionTypesJob;
use Illuminate\Console\Command;

class PullQuestionTypesCommand extends Command
{
    protected $signature = 'question-types:pull';

    protected $description = 'Dispatch Question Types synchronization job';

    public function handle()
    {
        PullQuestionTypesJob::dispatch();

        $this->info('Question Types synchronization job dispatched.');

        return Command::SUCCESS;
    }
}