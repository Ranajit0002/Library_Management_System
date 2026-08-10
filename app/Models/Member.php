<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_no',
        'joining_date',
        'name',
        'email',
        'phone',
        'address',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bookIssues(): HasMany
    {
        return $this->hasMany(BookIssue::class, 'member_id', 'id');
    }

    public function activeBorrowings(): HasMany
    {
        return $this->hasMany(BookIssue::class, 'member_id', 'id')
            ->whereIn('status', ['issued', 'borrowed', 'pending']);
    }

    public function isActive(): bool
    {
        return strtolower($this->status ?? '') === 'active';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('membership_no', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%");
        });
    }
}
