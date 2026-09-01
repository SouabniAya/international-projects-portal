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
}