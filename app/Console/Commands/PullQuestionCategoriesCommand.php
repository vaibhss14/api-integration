<?php

namespace App\Console\Commands;

use App\Jobs\PullQuestionCategoriesJob;
use Illuminate\Console\Command;

class PullQuestionCategoriesCommand extends Command
{
    protected $signature = 'question-categories:pull';

    protected $description = 'Dispatch Question Categories synchronization job';

    public function handle()
    {
        PullQuestionCategoriesJob::dispatch();

        $this->info('Question Categories synchronization job dispatched.');

        return Command::SUCCESS;
    }
}