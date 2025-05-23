<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'topic_id',
        'user_id',
        'is_answer',
    ];

    /**
     * Get the topic that this reply belongs to.
     */
    public function topic()
    {
        return $this->belongsTo(ForumTopic::class);
    }

    /**
     * Get the user who created this reply.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
