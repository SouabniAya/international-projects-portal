<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegionTranslation extends Model
{
    protected $table = 'RegionTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['regionID', 'languageCode', 'regionName'];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'regionID', 'regionID');
    }
}