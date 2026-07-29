<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('countries:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('industries:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('study-types:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('survey-statuses:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('redirect-types:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('return-statuses:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('business-verticals:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('question-types:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('question-categories:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('questions:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('question-answers:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('surveys:pull')
    ->everyFifteenMinutes()
    ->withoutOverlapping(60);

Schedule::command('survey-qualifications:pull')
    ->everyFifteenMinutes()
    ->withoutOverlapping(60);

Schedule::command('survey-quotas:pull')
    ->everyFifteenMinutes()
    ->withoutOverlapping(60);

Schedule::command('survey-groups:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('survey-blocked-ip-addresses:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('supplier-blocked-ip-addresses:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('supplier-blocked-respondents:pull')
    ->daily()
    ->withoutOverlapping(60);

Schedule::command('general-remaining:pull')
    ->daily()
    ->withoutOverlapping(60);
