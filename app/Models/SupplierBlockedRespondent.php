<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierBlockedRespondent extends Model
{
    protected $fillable = [

        'user_id',
        'completes',
        'reconcile_rate',
        'updated_timestamp',

    ];
}
