<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [

        'survey_id',
        'survey_name',
        'industry_id',
        'country_id',
        'study_type_id',

        'cpi',
        'loi',
        'ir',

        'collect_pii',

        'is_mobile',
        'is_tablet',
        'is_desktop',

        'is_survey_group_exist',

        'client_id',
        'account_id',

        'live_link',
        'test_link',

        'update_timestamp',
        'qual_update_timestamp',
        'quota_update_timestamp',
        'group_update_timestamp',
    ];
}
