<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'event_date', 'location', 'speaker',
        'poster_url', 'registration_fee', 'max_participants', 'created_by'
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function creator() // Panitia yang membuat event
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function registeredUsers()
    {
        return $this->belongsToMany(User::class, 'event_registrations');
    }
}
