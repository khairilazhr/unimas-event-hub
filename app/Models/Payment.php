<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_reg_id', 
        'user_id',
        'ref_no',
        'receipt'
    ];

    public function payment()
{
    return $this->hasOne(Payment::class, 'event_reg_id');
}
}
