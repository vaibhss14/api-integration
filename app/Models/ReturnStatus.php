<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnStatus extends Model
{
    protected $fillable = [
        'return_status_id',
        'description',
    ];
}
