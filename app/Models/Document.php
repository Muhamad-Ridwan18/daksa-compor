<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'document_number',
        'description',
        'content_html',
        'excerpt',
        'published_date',
        'is_new',
        'document_file',
        'document_url',
        'categories',
        'source',
        'document_type',
        'author_id',
        'is_published',
        'published_at',
        'views',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'is_published' => 'boolean',
        'published_date' => 'date',
        'published_at' => 'datetime',
        'categories' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (empty($document->slug)) {
                $document->slug = Str::slug($document->title);
            }
        });

        static::updating(function ($document) {
            if ($document->isDirty('title') && empty($document->slug)) {
                $document->slug = Str::slug($document->title);
            }
        });
    }

    /**
     * Get the author of the document.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope a query to only include published documents.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Increment the view count.
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get the excerpt or generate from description.
     */
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        return Str::limit(strip_tags($this->description), 150);
    }

    /**
     * Get the document file URL.
     */
    public function getDocumentFileUrlAttribute()
    {
        if ($this->document_file) {
            return Storage::url($this->document_file);
        }
        
        return $this->document_url;
    }

    /**
     * Check if document should be shown as new.
     * Returns true if is_new flag is set OR if published within last 7 days.
     */
    public function shouldShowAsNew()
    {
        if ($this->is_new) {
            return true;
        }
        
        // Auto-check if published within last 7 days
        if ($this->published_at) {
            return $this->published_at->isAfter(now()->subDays(7));
        }
        
        return false;
    }

    /**
     * Get categories as comma-separated string.
     */
    public function getCategoriesStringAttribute()
    {
        if (!$this->categories || !is_array($this->categories)) {
            return '';
        }
        
        return implode(', ', $this->categories);
    }
}
