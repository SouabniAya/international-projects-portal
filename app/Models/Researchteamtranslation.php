<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchTeamTranslation extends Model
{
    protected $table = 'ResearchTeamTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['teamID', 'languageCode', 'name', 'description'];

    public function team()
    {
        return $this->belongsTo(ResearchTeam::class, 'teamID', 'teamID');
    }
}