<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'country', 'role',
        'dxn_member_id', 'referral_code', 'referred_by', 'is_active',
        'profile_image', 'bio', 'total_sales', 'total_downlines',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_active'      => 'boolean',
        'total_sales'    => 'float',
        'total_downlines'=> 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->referral_code)) {
                $user->referral_code = strtoupper(Str::random(8));
            }
            // Auto-hash password on create (like Mongoose pre-save)
            if ($user->password && !str_starts_with($user->password, '$2y$') && !str_starts_with($user->password, '$2a$')) {
                $user->password = Hash::make($user->password);
            }
        });

        static::updating(function (User $user) {
            // Auto-hash password on update if changed
            if ($user->isDirty('password') && !str_starts_with($user->password, '$2y$') && !str_starts_with($user->password, '$2a$')) {
                $user->password = Hash::make($user->password);
            }
        });
    }

    // ── JWT ───────────────────────────────────────────────
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return ['role' => $this->role];
    }

    // ── Relationships ─────────────────────────────────────
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    // Alias for eager loading with camelCase name
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function downlines()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ── Serialisation: expose _id alongside id ────────────
    public function toArray(): array
    {
        $array = parent::toArray();
        $array['_id'] = $array['id'];
        return $array;
    }
}
