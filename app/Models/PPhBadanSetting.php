<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPhBadanSetting extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pph_badan_settings';

    protected $fillable = [
        'key',
        'value',
        'label',
        'description',
        'category',
        'sort_order',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    /**
     * Get setting value by key.
     */
    public static function getValue($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? (float) $setting->value : $default;
    }

    /**
     * Get all settings as key-value array.
     */
    public static function getAllAsArray()
    {
        return static::pluck('value', 'key')->map(function ($value) {
            return (float) $value;
        })->toArray();
    }

    /**
     * Get settings grouped by category.
     */
    public static function getByCategory()
    {
        return static::orderBy('sort_order')->get()->groupBy('category');
    }
}
