<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_id',
        'organizer_id',
        'status',
        'published_at',
        'expires_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }
}