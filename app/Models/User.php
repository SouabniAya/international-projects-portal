<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'user';

    protected $primaryKey = 'userID';

    public $timestamps = false;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'userName',
        'phoneNumber',
        'accountStatus',
        'twoFactorEnabled',
        'passwordResetToken',
        'tokenExpiresAt',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'passwordResetToken',
    ];

    protected $casts = [
        'twoFactorEnabled' => 'boolean',
        'tokenExpiresAt'   => 'datetime',
    ];

    /**
     * Login history.
     */
    public function loginHistory(): HasMany
    {
        return $this->hasMany(
            LoginHistory::class,
            'userID',
            'userID'
        );
    }

    /**
     * Roles assigned to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'AssignedRole',
            'userID',
            'roleID',
            'userID',
            'roleID'
        );
    }

    /**
     * Permissions inherited through roles.
     */
    public function permissions()
    {
        return Permission::query()
            ->whereHas('roles.users', function ($query) {
                $query->where('User.userID', $this->userID);
            });
    }

    /**
     * True when the user has a super-administrator role.
     * Accepts the role labels used by the project database/UI.
     */
    public function isSuperAdmin(): bool
    {
        return $this->roles()->where(function ($query) {
            $query->whereRaw("LOWER(roleName) IN (?, ?, ?)", [
                'super admin',
                'super administrator',
                'super-administrator',
            ])->orWhereRaw("LOWER(roleName) LIKE ?", ['%super%admin%']);
        })->exists();
    }

    /**
     * True when the user has a functional-administrator role.
     */
    public function isFunctionalAdmin(): bool
    {
        return $this->roles()->where(function ($query) {
            $query->whereRaw("LOWER(roleName) IN (?, ?, ?)", [
                'functional admin',
                'functional administrator',
                'functional-administrator',
            ])->orWhereRaw("LOWER(roleName) LIKE ?", ['%functional%admin%']);
        })->exists();
    }

    /**
     * Content managers include both administrator roles.
     */
    public function canManageContent(): bool
    {
        return $this->isSuperAdmin() || $this->isFunctionalAdmin();
    }

    /**
     * Full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->firstName} {$this->lastName}");
    }

    /**
     * Account status.
     */
    public function isActive(): bool
    {
        return $this->accountStatus === 'active';
    }
}