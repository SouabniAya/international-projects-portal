<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolPresentation extends Model
{
    protected $table = 'SchoolPresentation';
    protected $primaryKey = 'presentationID';
    public $timestamps = false;

    protected $fillable = [
        'officeEmail',
        'officePhone',
        'publicationDate',
        'publicationStatus',
        'publishedAt',
        'scheduledAt',
        'publishedByUserID',
    ];

    public function translations()
    {
        return $this->hasMany(SchoolPresentationTranslation::class, 'presentationID', 'presentationID');
    }

    public function officeHours()
    {
        return $this->hasOne(OfficeHours::class, 'presentationID', 'presentationID');
    }
}