<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_id',
        'description',
        'question_category_id',
        'question_type_id',
        'localization_code',
    ];
}
