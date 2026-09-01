<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = 'Notification';
    protected $primaryKey = 'notificationID';
    public $timestamps = false;

    protected $fillable = ['type', 'content', 'isRead', 'createdAt', 'userID'];

    protected $casts = [
        'isRead' => 'boolean',
        'createdAt' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('isRead', false);
    }

    public function scopeForUser(Builder $query, int $userID): Builder
    {
        return $query->where('userID', $userID);
    }
}
