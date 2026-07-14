<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $fillable = [
        'answer_id',
        'question_id',
        'localization_code',
        'description',
    ];

    public function question()
    {
        return $this->belongsTo(
            Question::class,
            'question_id',
            'question_id'
        );
    }
}
