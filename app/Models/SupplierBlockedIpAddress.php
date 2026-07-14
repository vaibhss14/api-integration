<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierBlockedIpAddress extends Model
{
    protected $fillable = [

        'ip_address',
        'completed_surveys',
        'reconcile_rate',
        'updated_timestamp',

    ];
}
