<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $table = 'Region';
    protected $primaryKey = 'regionID';
    public $timestamps = false;

    public function translations(): HasMany
    {
        return $this->hasMany(RegionTranslation::class, 'regionID', 'regionID');
    }

    public function countries(): HasMany
    {
        return $this->hasMany(Country::class, 'regionID', 'regionID');
    }
}