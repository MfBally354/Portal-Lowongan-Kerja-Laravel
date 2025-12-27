<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $table = 'job_listings';

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'location',
        'type',
        'category',
        'salary_min',
        'salary_max',
        'requirements',
        'is_active',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_listing_id');
    }

    public function hasApplied($userId)
    {
        return $this->applications()->where('user_id', $userId)->exists();
    }
}
