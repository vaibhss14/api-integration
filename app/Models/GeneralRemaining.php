<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralRemaining extends Model
{
    protected $fillable = [

        'survey_id',
        'total_remaining',
        'total_reserved_remaining',
        'reservation_expiration',

    ];
}
