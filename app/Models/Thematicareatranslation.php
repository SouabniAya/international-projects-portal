<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThematicAreaTranslation extends Model
{
    protected $table = 'ThematicAreaTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['areaID', 'languageCode', 'areaName', 'description'];

    public function area()
    {
        return $this->belongsTo(ThematicArea::class, 'areaID', 'areaID');
    }
}