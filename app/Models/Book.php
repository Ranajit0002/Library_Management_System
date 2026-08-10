<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'publish_year' => 'integer',
        'quantity' => 'integer',
        'available_quantity' => 'integer',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function bookIssues(): HasMany
    {
        return $this->hasMany(BookIssue::class);
    }

    // Query Scopes
    public function scopeAvailable($query)
    {
        return $query
            ->where('status', 'available')
            ->where('available_quantity', '>', 0);
    }

    // Accessors
    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        return asset('images/no-book-cover.png');
    }

    public function getEbookUrlAttribute(): ?string
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }

        return null;
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->available_quantity > 0;
    }

    // Helpers
    public function hasEbook(): bool
    {
        return !empty($this->file_path);
    }
}
