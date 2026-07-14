<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQualification extends Model
{
    protected $fillable = [

        'survey_id',
        'qualification_id',
        'answer_id',
        'update_timestamp',

    ];
}
