<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeHoursTranslation extends Model
{
    protected $table = 'OfficeHoursTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['hoursID', 'languageCode', 'hoursText'];

    public function officeHours()
    {
        return $this->belongsTo(OfficeHours::class, 'hoursID', 'hoursID');
    }
}