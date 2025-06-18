<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'organizer_name',
        'date',
        'location',
        'poster',
        'organizer_id',
        'qr_code',
        'payment_details',
        'supporting_docs',
        'refund_type',
        'refund_policy',
        'status',
    ];

    /**
     * Get the tickets for this event.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'eventId');
    }

    /**
     * Get the registrations for this event.
     */
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    // Relationship with User model
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function getTotalParticipantsAttribute()
    {
        return $this->registrations()->count();
    }

    public function forumTopics()
    {
        return $this->hasMany(ForumTopic::class);
    }

    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class);
    }
}
