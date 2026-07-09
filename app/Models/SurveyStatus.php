<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyStatus extends Model
{
    protected $fillable = [
        'survey_status_id',
        'status_name',
    ];
}
