<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('countries:pull')->daily();

Schedule::command('industries:pull')->daily();

Schedule::command('study-types:pull')->daily();

Schedule::command('survey-statuses:pull')->daily();

Schedule::command('redirect-types:pull')->daily();

Schedule::command('business-verticals:pull')->daily();

Schedule::command('question-types:pull')->daily();

Schedule::command('question-categories:pull')->daily();

Schedule::command('questions:pull')->daily();

Schedule::command('question-answers:pull')->daily();

Schedule::command('surveys:pull')->daily();

Schedule::command('survey-qualifications:pull')->daily();

Schedule::command('survey-quotas:pull')->daily();

Schedule::command('survey-groups:pull')->daily();

Schedule::command('survey-blocked-ip-addresses:pull')->daily();

Schedule::command('supplier-blocked-ip-addresses:pull')->daily();

Schedule::command('supplier-blocked-respondents:pull')->daily();

Schedule::command('general-remainings:pull')->daily();
