<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoSetting extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'route_name',
        'page_type',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_robots',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'og_url',
        'og_site_name',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'twitter_site',
        'twitter_creator',
        'schema_json',
    ];

    protected $casts = [
        'schema_json' => 'array',
    ];

    /**
     * Get the parent seoable model.
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get SEO setting by route name.
     */
    public static function getByRoute($routeName)
    {
        return static::where('route_name', $routeName)->first();
    }

    /**
     * Get SEO setting by model.
     */
    public static function getByModel($model)
    {
        if (!$model) {
            return null;
        }

        return static::where('seoable_type', get_class($model))
            ->where('seoable_id', $model->id)
            ->first();
    }
}
