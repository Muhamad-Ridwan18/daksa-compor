<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerTable extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ter_tables';

    protected $fillable = [
        'kategori',
        'min',
        'max',
        'tarif_percent',
        'sort_order',
    ];

    protected $casts = [
        'min' => 'decimal:2',
        'max' => 'decimal:2',
        'tarif_percent' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    /**
     * Get TER table by kategori
     */
    public static function getByKategori($kategori)
    {
        return static::where('kategori', $kategori)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                return [
                    $item->min,
                    $item->max,
                    $item->tarif_percent,
                ];
            })
            ->toArray();
    }

    /**
     * Get all TER tables as array format [min, max, tarif_percent]
     */
    public static function getAllAsArray()
    {
        $result = [];
        $kategoris = ['TER A', 'TER B', 'TER C'];
        
        foreach ($kategoris as $kategori) {
            $result[$kategori] = self::getByKategori($kategori);
        }
        
        return $result;
    }
}
