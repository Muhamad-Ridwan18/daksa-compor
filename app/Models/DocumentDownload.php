<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentDownload extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'document_id',
        'nama_lengkap',
        'email',
        'no_telpon',
        'nama_perusahaan',
    ];

    /**
     * Get the document that was downloaded.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
