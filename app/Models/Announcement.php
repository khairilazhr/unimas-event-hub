<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'eventId',
        'title',
        'content',
        'announcement_date',
        'created_by'
    ];

    /**
     * Get the event that owns the announcement
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'eventId', 'id');
    }
}