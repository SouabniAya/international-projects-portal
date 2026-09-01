<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasTranslations;

    protected $table = 'News';
    protected $primaryKey = 'newsID';
    public $timestamps = false;

    protected $fillable = [
        'image', 'publicationDate', 'publicationStatus', 'publishedAt',
        'scheduledAt', 'projectID', 'mobilityID', 'publishedByUserID',
    ];

    protected $casts = [
        'publicationDate' => 'date',
        'publishedAt' => 'datetime',
        'scheduledAt' => 'datetime',
    ];

    public function translations()
    {
        return $this->hasMany(NewsTranslation::class, 'newsID');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'projectID', 'projectID');
    }

    public function mobility()
    {
        return $this->belongsTo(MobilityOpportunity::class, 'mobilityID', 'mobilityID');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publishedByUserID', 'userID');
    }

    public function scopePublished($query)
    {
        return $query->where('publicationStatus', 'published');
    }
}