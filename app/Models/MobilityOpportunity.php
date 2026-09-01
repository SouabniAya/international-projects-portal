<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class MobilityOpportunity extends Model
{
    use HasTranslations;

    protected $table = 'MobilityOpportunity';
    protected $primaryKey = 'mobilityID';
    public $timestamps = false;

    protected $fillable = [
        'hostingEstablishment', 'city', 'targetAudience', 'placesAvailable',
        'startDate', 'endDate', 'requiredLanguageSkills', 'applicationDeadline',
        'contact', 'fundingAvailable', 'applicationLink', 'featured',
        'publicationStatus', 'publishedAt', 'scheduledAt', 'programID',
        'countryCode', 'publishedByUserID', 'hostedByPartner', 'mobilityType',
    ];

    protected $casts = [
        'startDate' => 'date',
        'endDate' => 'date',
        'applicationDeadline' => 'date',
        'featured' => 'boolean',
        'publishedAt' => 'datetime',
        'scheduledAt' => 'datetime',
    ];

    public function translations()
    {
        return $this->hasMany(MobilityOpportunityTranslation::class, 'mobilityID');
    }

    public function programme()
    {
        return $this->belongsTo(FundingProgramme::class, 'programID');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryCode', 'countryCode');
    }

    public function hostPartner()
    {
        return $this->belongsTo(Partner::class, 'hostedByPartner');
    }
    public function documents()
{
    return $this->hasMany(MobilityDocument::class, 'mobilityID')->with('document');
}
public function publisher()
    {
        return $this->belongsTo(User::class, 'publishedByUserID', 'userID');
    }
}