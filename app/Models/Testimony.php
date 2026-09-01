<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    protected $table = 'Testimony';
    protected $primaryKey = 'testimonyID';
    public $timestamps = false;

    protected $fillable = [
        'authorName',
        'authorRole',
        'photo',
        'date',
        'projectID',
        'mobilityID',
        'status',
        'reviewedByUserID',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function translations()
    {
        return $this->hasMany(TestimonyTranslation::class, 'testimonyID', 'testimonyID');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'projectID', 'projectID');
    }

    public function mobility()
    {
        return $this->belongsTo(MobilityOpportunity::class, 'mobilityID', 'mobilityID');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}