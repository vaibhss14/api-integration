<?php

namespace App\Console\Commands;

use App\Jobs\PullQuestionAnswersJob;
use Illuminate\Console\Command;

class PullQuestionAnswersCommand extends Command
{
    protected $signature = 'question-answers:pull';

    protected $description = 'Pull question answers from API';

    public function handle()
    {
        PullQuestionAnswersJob::dispatch();

        $this->info('PullQuestionAnswersJob dispatched successfully.');

        return Command::SUCCESS;
    }
}