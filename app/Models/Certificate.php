<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $fillable = ['event_registration_id', 'certificate_url', 'uploaded_by'];

    public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class);
    }

    public function uploader() // Panitia yang upload
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}