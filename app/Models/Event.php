<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasTranslations;

    protected $table = 'Event';
    protected $primaryKey = 'eventID';
    public $timestamps = false;

    protected $fillable = [
        'eventType', 'startDate', 'endDate', 'location', 'projectID',
        'publicationStatus', 'publishedAt', 'scheduledAt', 'publishedByUserID',
    ];

    protected $casts = [
        'startDate' => 'datetime',
        'endDate' => 'datetime',
        'publishedAt' => 'datetime',
        'scheduledAt' => 'datetime',
    ];

    public function translations()
    {
        return $this->hasMany(EventTranslation::class, 'eventID');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'projectID', 'projectID');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publishedByUserID', 'userID');
    }

    public function scopePublished($query)
    {
        return $query->where('publicationStatus', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('startDate', '>=', now());
    }
}