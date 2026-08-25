<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeHours extends Model
{
    protected $table = 'OfficeHours';
    protected $primaryKey = 'hoursID';
    public $timestamps = false;

    protected $fillable = ['presentationID'];

    public function presentation()
    {
        return $this->belongsTo(SchoolPresentation::class, 'presentationID', 'presentationID');
    }

    public function translations()
    {
        return $this->hasMany(OfficeHoursTranslation::class, 'hoursID', 'hoursID');
    }
}