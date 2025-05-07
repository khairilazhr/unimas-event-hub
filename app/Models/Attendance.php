<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    public const STATUS_REGISTERED = 'registered';
    public const STATUS_ATTENDED   = 'attended';
    public const STATUS_ABSENT     = 'absent';

    protected $fillable = [
        'event_registration_id',
        'event_id',
        'ticket_id',
        'user_id',
        'status',
        'attended_at',
    ];

    protected static function booted()
    {
        static::creating(function ($attendance) {
            // Set default status if not provided
            $attendance->status = $attendance->status ?? self::STATUS_REGISTERED;

            // Validate status
            if (! in_array($attendance->status, self::validStatuses())) {
                throw new \InvalidArgumentException("Invalid attendance status");
            }
        });
    }

    public static function validStatuses()
    {
        return [
            self::STATUS_REGISTERED,
            self::STATUS_ATTENDED,
            self::STATUS_ABSENT,
        ];
    }

    public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
