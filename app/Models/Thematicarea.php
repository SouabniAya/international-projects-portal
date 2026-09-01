<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThematicArea extends Model
{
    protected $table = 'ThematicArea';
    protected $primaryKey = 'areaID';
    public $timestamps = false;

    public function translations()
    {
        return $this->hasMany(ThematicAreaTranslation::class, 'areaID', 'areaID');
    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'CooperatesIn', 'areaID', 'partnerID');
    }
}