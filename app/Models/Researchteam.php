<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchTeam extends Model
{
    protected $table = 'ResearchTeam';
    protected $primaryKey = 'teamID';
    public $timestamps = false;

    protected $fillable = [
        'link',
        'publicationDate',
        'publicationStatus',
        'publishedAt',
        'scheduledAt',
        'publishedByUserID',
    ];

    public function translations()
    {
        return $this->hasMany(ResearchTeamTranslation::class, 'teamID', 'teamID');
    }
}