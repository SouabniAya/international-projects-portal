<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTranslation extends Model
{
    protected $table = 'ProjectTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = [
        'projectID', 'languageCode', 'title', 'abstract', 'objectives',
        'targetGroups', 'keyResults', 'publicDeliverables', 'publications',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'projectID', 'projectID');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'languageCode', 'languageCode');
    }
}
