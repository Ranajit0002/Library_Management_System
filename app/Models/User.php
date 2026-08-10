<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $role
 * @property string|null $avatar
 * @property string $avatar_url
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Member|null $member
 * @method \Illuminate\Database\Eloquent\Relations\MorphMany notifications()
 * @method \Illuminate\Database\Query\Builder unreadNotifications()
 * @method \Illuminate\Database\Query\Builder readNotifications()
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes & Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Accessor for user avatar URL with default UI-Avatars fallback.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=4F46E5&background=E0E7FF';
    }

    /*
    |--------------------------------------------------------------------------
    | Role Helpers (Backend & Auth Middleware)
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user has Admin role.
     */
    public function isAdmin(): bool
    {
        return strtolower($this->role ?? '') === 'admin';
    }

    /**
     * Check if user has Member role.
     */
    public function isMember(): bool
    {
        return strtolower($this->role ?? '') === 'member' || !$this->isAdmin();
    }

    /*
    |--------------------------------------------------------------------------
    | Eloquent Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Direct relationship to Member record via user_id.
     */
    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'user_id', 'id');
    }

    /**
     * Relationship to BookIssues through Member model.
     */
    public function bookIssues(): HasManyThrough
    {
        return $this->hasManyThrough(
            BookIssue::class,
            Member::class,
            'user_id',   // Foreign key on members table...
            'member_id', // Foreign key on book_issues table...
            'id',        // Local key on users table...
            'id'         // Local key on members table...
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Get or dynamically resolve/create the associated Member profile.
     */
    public function getOrCreateMemberProfile(): Member
    {
        // 1. Try direct relationship query
        $member = $this->member()->first();
        if ($member) {
            return $member;
        }

        // 2. Try matching existing member profile by email
        $memberByEmail = Member::where('email', $this->email)->first();
        if ($memberByEmail) {
            $memberByEmail->update(['user_id' => $this->id]);
            return $memberByEmail;
        }

        // 3. Fallback: Auto-generate member record if none exists
        return Member::create([
            'user_id'       => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'phone'         => null,
            'address'       => null,
            'status'        => 'active',
            'membership_no' => 'MEM-' . strtoupper(substr(md5($this->id . time()), 0, 6)),
        ]);
    }
}