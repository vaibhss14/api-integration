<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
     protected $fillable = [
        'country_id',
        'localization_code',
        'country_name',
        'languages',
     ] ;
}
