<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    const STATUS_REGISTERED = 'registered';
    const STATUS_ATTENDED = 'attended';

    protected $fillable = [
        'event_registration_id',
        'status',
        'attended_at'
    ];

    protected $dates = [
        'attended_at'
    ];

    public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class);
    }

    // You can access event, ticket, and user through event registration
    public function event()
    {
        return $this->eventRegistration->event();
    }

    public function ticket()
    {
        return $this->eventRegistration->ticket();
    }

    public function user()
    {
        return $this->eventRegistration->user();
    }
}
