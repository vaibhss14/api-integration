<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
  protected $fillable = [
        'question_type_id',
        'question_type_name',
    ];
}
