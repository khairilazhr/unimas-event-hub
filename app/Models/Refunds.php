<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refunds extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'event_registration_id',
        'user_id',
        'refund_amount',
        'refund_reason',
        'status',
        'refund_proof', 
        'notes',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
    ];

    /**
     * Get the ticket associated with this refund.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user who requested this refund.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event registration associated with this refund.
     */
    public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }
}