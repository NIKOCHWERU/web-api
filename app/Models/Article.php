<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'summary', 'content', 'image',
        'status', 'tags', 'is_published', 'published_at',
        'category_id', 'supporting_images', 'meta_title',
        'meta_description', 'focus_keyword', 'canonical_url',
        'seo_score', 'readability_score', 'views',
    ];

    protected $casts = [
        'is_published'      => 'boolean',
        'published_at'      => 'datetime',
        'supporting_images' => 'array',
        'tags'              => 'array',
        'seo_score'         => 'integer',
        'views'             => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($article) {
            $article->is_published = ($article->status === 'published');
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        $path = ltrim($this->image, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        return \Illuminate\Support\Facades\Storage::url($path);
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
