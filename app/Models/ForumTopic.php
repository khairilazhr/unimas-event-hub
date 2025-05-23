<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'event_id',
        'user_id',
        'is_resolved',
    ];

    /**
     * Get the event that this topic is related to.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user who created this topic.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the replies for this topic.
     */
    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'topic_id');
    }

    /**
     * Check if this topic has an answer marked as solution.
     */
    public function hasAnswer()
    {
        return $this->replies()->where('is_answer', true)->exists();
    }
}
