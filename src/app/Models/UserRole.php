<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Role;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user_role';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            // Set created_at when a new record is inserted in the pivot table
            $model->created_at = now();
        });

        static::updating(function ($model) {
            // Set updated_at when a record is updated in the pivot table
            $model->updated_at = now();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scopePsychologist($query)
    {
        return $query->whereHas('role', function ($query) {
            $query->where('name', 'psychologist');
        });
    }

    public function scopeUser($query)
    {
        return $query->whereHas('role', function ($query) {
            $query->where('name', 'user');
        });
    }

}
