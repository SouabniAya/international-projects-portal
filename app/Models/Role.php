<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'Role';

    protected $primaryKey = 'roleID';

    public $timestamps = false;

    protected $fillable = [
        'roleName',
    ];

    /**
     * Users assigned to this role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'AssignedRole',
            'roleID',
            'userID',
            'roleID',
            'userID'
        );
    }

    /**
     * Permissions granted to this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'RoleGrant',
            'roleID',
            'permissionID',
            'roleID',
            'permissionID'
        );
    }
}