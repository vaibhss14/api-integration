<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuota extends Model
{
    protected $fillable = [

        'survey_id',
        'quota_id',
        'quota_name',
        'total_remaining',
        'qualification_id',
        'answer_id',
        'update_timestamp',

    ];
}
