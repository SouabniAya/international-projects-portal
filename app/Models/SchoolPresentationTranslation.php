<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolPresentationTranslation extends Model
{
    protected $table = 'SchoolPresentationTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = [
        'presentationID',
        'languageCode',
        'description',
        'internationalizationStrategy',
        'vision',
        'missions',
        'objectives',
        'teachingResearchDomains',
        'partnershipBenefits',
        'academicCalendar',
        'registrationProcedure',
        'officeAddress',
        'officeLocation',
    ];

    public function presentation()
    {
        return $this->belongsTo(SchoolPresentation::class, 'presentationID', 'presentationID');
    }
}