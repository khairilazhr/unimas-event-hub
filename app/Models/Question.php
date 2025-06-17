<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'questionnaire_id',
        'question_text',
        'question_type',
        'is_required',
        'order'
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class)->orderBy('order');
    }

    public function responses()
    {
        return $this->hasMany(QuestionResponse::class);
    }
}