<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['psychologist_id', 'start_time', 'end_time', 'client_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }

    /**
     * Get the psychologist that owns the time slot.
     */
    public function psychologist()
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }
}
