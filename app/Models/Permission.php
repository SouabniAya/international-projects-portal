<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $table = 'Permission';

    protected $primaryKey = 'permissionID';

    public $timestamps = false;

    protected $fillable = [
        'label',
    ];

    /**
     * Roles that have this permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'RoleGrant',
            'permissionID',
            'roleID',
            'permissionID',
            'roleID'
        );
    }
}