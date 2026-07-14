<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyGroup extends Model
{
    protected $fillable = [

        'survey_id',
        'survey_group_id',
        'survey_group_name',
        'grouped_survey_id',
        'return_restriction_status_id',

    ];
}
