<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'eventId',
        'price',
        'type',
        'description',
        'section',
        'row',
        'seat',
        'status',
    ];

    /**
     * Get the event that owns the ticket.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'eventId');
    }

    /**
     * Get the registrations for this ticket.
     */
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'ticket_id');
    }

    public function refunds()
    {
    return $this->hasMany(\App\Models\Refunds::class, 'ticket_id');
    }
}
