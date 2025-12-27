<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
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
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function hasApplied($userId)
    {
        return $this->applications()->where('user_id', $userId)->exists();
    }
}
