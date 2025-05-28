<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'event_id', 'registration_code', 'qr_code_url',
        'payment_status', 'proof_of_payment_url', 'payment_verified_by',
        'payment_verified_at', 'payment_rejection_reason', 'is_attended',
        'scanned_at', 'scanned_by'
    ];

    protected $casts = [
        'payment_verified_at' => 'datetime',
        'scanned_at' => 'datetime',
        'is_attended' => 'boolean',
    ];

    public function user() // Member yang mendaftar
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function paymentVerifier() // Tim Keuangan yang verifikasi
    {
        return $this->belongsTo(User::class, 'payment_verified_by');
    }

    public function scanner() // Panitia yang scan
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
