<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyType extends Model
{
    protected $fillable = [
        'study_type_id',
        'study_name',
    ];
}
