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

    protected $table = 'User';

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