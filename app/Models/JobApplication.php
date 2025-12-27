<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_listing_id', // ← FIX INI (ganti job_id)
        'user_id',
        'cover_letter',
        'resume',
        'status',
    ];

    public function job()
    {
        return $this->belongsTo(JobListing::class, 'job_listing_id'); // ← FIX INI
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
