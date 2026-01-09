<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_description',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $baseSlug = Str::slug($service->name);
                $slug = $baseSlug;
                $counter = 1;

                // Ensure unique slug
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                $service->slug = $slug;
            }
        });

        static::updating(function ($service) {
            // Auto-update slug if name changed and slug is not being manually edited
            if ($service->isDirty('name') && !$service->isDirty('slug')) {
                $baseSlug = Str::slug($service->name);
                $slug = $baseSlug;
                $counter = 1;

                // Ensure unique slug
                while (static::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                $service->slug = $slug;
            }
        });
    }

    /**
     * Get the products for the service.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }

    /**
     * Scope a query to only include active services.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
