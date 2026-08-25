<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginHistory extends Model
{
    protected $table = 'LoginHistory';

    protected $primaryKey = 'loginID';

    public $timestamps = false;

    protected $fillable = [
        'loginTime',
        'userID',
        'successful',
        'ipAddress',
        'failureReason',
    ];

    protected $casts = [
        'loginTime'  => 'datetime',
        'successful' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'userID',
            'userID'
        );
    }
}