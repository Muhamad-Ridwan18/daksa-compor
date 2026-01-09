<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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
        'meta_description',
        'description',
        'requirements',
        'benefits',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deadline' => 'date',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($job) {
            if (empty($job->slug)) {
                $baseSlug = Str::slug($job->title);
                $slug = $baseSlug;
                $counter = 1;

                // Ensure unique slug
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                $job->slug = $slug;
            }
        });

        static::updating(function ($job) {
            // Auto-update slug if title changed and slug is not being manually edited
            if ($job->isDirty('title') && !$job->isDirty('slug')) {
                $baseSlug = Str::slug($job->title);
                $slug = $baseSlug;
                $counter = 1;

                // Ensure unique slug
                while (static::where('slug', $slug)->where('id', '!=', $job->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                $job->slug = $slug;
            }
        });
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}


