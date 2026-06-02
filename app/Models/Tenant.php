<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'domain_prefix', 'logo_path', 'address', 'status'])]
class Tenant extends Model
{
    use SoftDeletes;

    /**
     * Cast attributes to specific data types.
     */
    protected function casts(): array
    {
        return [
            'trial_ends_at' => 'datetime',
        ];
    }

    /**
     * Automatically generate ULID upon creation.
     * Database uses incrementing ID, while the browser/routes use ULID.
     */
    protected static function booted(): void
    {
        static::creating(function ($tenant) {
            if (empty($tenant->ulid)) {
                $tenant->ulid = (string) Str::ulid();
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

    /**
     * Get the users that belong to this tenant.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
