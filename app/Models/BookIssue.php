<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $book_id
 * @property int $member_id
 * @property string $issue_date
 * @property string $due_date
 * @property string $return_date
 * @property string|null $actual_return_date
 * @property string $status
 * @property string|float $fine
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class BookIssue extends Model
{
    use HasFactory;

    protected $table = 'book_issues';

    protected $fillable = [
        'book_id',
        'member_id',
        'issue_date',
        'due_date',
        'return_date',
        'actual_return_date',
        'status',
        'fine',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
        'fine' => 'decimal:2',
    ];

    /**
     * Book belonging to this issue.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Member who borrowed the book.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope active (issued) books.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'issued');
    }

    /**
     * Scope overdue books.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', 'issued')
            ->whereDate('return_date', '<', now());
    }
}