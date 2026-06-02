<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password', 'role', 'tenant_id'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, SoftDeletes;

    /**
     * Role Authorization Helpers
     */
    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isTenantAdmin(): bool
    {
        return $this->role === 'tenant_admin';
    }

    public function isManagerOrAbove(): bool
    {
        return in_array($this->role, ['tenant_admin', 'manager']);
    }

    /**
     * Automatically generate a ULID upon creation.
     */
    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (empty($user->ulid)) {
                $user->ulid = (string) Str::ulid();
            }
        });
    }

    /**
     * Bind routes using the 'ulid' column instead of the default 'id'.
     */
    public function getRouteKeyName(): string
    {
        return 'ulid';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'superadmin'   => 'Platform Administrator',
            'tenant_admin' => 'Tenant Owner',
            'manager'      => 'Manager',
            'staff'        => 'Staff Member',
            default        => 'User',
        };
    }

    /**
     * Get the tenant that owns the user.
     * If NULL, the user is a Superadmin managing the platform.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Cast attributes to specific data types.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Generate user initials for UI avatars.
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
