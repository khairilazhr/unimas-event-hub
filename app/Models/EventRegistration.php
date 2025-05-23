<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'ticket_id',
        'user_id',
        'name',
        'email',
        'phone',
        'notes',
        'status',
    ];

    /**
     * Get the event that owns the registration.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the ticket associated with this registration.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user who made this registration.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
