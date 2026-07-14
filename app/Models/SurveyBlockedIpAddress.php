<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyBlockedIpAddress extends Model
{
    protected $fillable = [

        'survey_id',
        'ip_address',
        'update_timestamp',

    ];
}
