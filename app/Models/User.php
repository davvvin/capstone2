<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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

    // ... (use statements dan properti lainnya) ...
public function roles()
{
    return $this->belongsToMany(Role::class, 'role_user');
}

public function hasRole($roleSlug)
{
    return $this->roles()->where('slug', $roleSlug)->exists();
}

// Event yang dibuat oleh user ini (jika dia panitia)
public function createdEvents()
{
    return $this->hasMany(Event::class, 'created_by');
}

// Registrasi event yang dilakukan oleh user ini
public function eventRegistrations()
{
    return $this->hasMany(EventRegistration::class);
}

// Event yang diverifikasi pembayarannya oleh user ini (jika dia tim keuangan)
public function verifiedPayments()
{
    return $this->hasMany(EventRegistration::class, 'payment_verified_by');
}

// Event yang discan kehadirannya oleh user ini (jika dia panitia)
public function scannedAttendees()
{
    return $this->hasMany(EventRegistration::class, 'scanned_by');
}

// Sertifikat yang diupload oleh user ini (jika dia panitia)
public function uploadedCertificates()
{
    return $this->hasMany(Certificate::class, 'uploaded_by');
}
// ...

}
