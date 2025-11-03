<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'vacancies';

    protected $fillable = [
        'title',
        'slug',
        'department',
        'location',
        'employment_type',
        'salary_range',
        'deadline',
        'is_active',
        'sort_order',
        'short_description',
        'description',
        'requirements',
        'benefits',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deadline' => 'date',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}


