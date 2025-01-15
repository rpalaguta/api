<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Flag to indicate if the role should be attached during seeding
    public static $isSeeding = false;

    /**
     * Automatically set the email_verified_at field to the current timestamp in development.
     */
    protected static function booted()
    {
        parent::boot();

         // Set email_verified_at only in development
         static::creating(function ($user) {
            if (app()->environment('local')) {
                $user->email_verified_at = now();
            }
        });

        // Attach the first role after the user is created, except when seeding
        static::created(function ($user) {
            if (!app()->runningInConsole()) {
                $user->roles()->attach(1);
            }
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class, 'psychologist_id');
    }

}
