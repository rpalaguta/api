<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Psychologist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }
}
