<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'Partner';
    protected $primaryKey = 'partnerID';
    public $timestamps = false;

    protected $fillable = [
        'partnerName', 'city', 'logo', 'establishmentType', 'partnershipType',
        'partnershipStatus', 'website', 'countryCode', 'publicationStatus',
        'publishedAt', 'scheduledAt', 'publishedByUserID', 'longitude', 'latitude',
    ];

    public function translations()
    {
        return $this->hasMany(PartnerTranslation::class, 'partnerID', 'partnerID');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryCode', 'countryCode');
    }

    public function thematicAreas()
    {
        return $this->belongsToMany(ThematicArea::class, 'CooperatesIn', 'partnerID', 'areaID');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'ProjectPartner', 'partnerID', 'projectID')
            ->withPivot('partnerRole');
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class, 'partnerID', 'partnerID');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publishedByUserID', 'userID');
    }

    public function scopeActive($query)
    {
        return $query->where('partnershipStatus', 'active')->where('publicationStatus', 'published');
    }
    public function translation(?string $locale = null): ?PartnerTranslation
{
    $locale ??= app()->getLocale();

    return $this->translations->firstWhere('languageCode', $locale)
        ?? $this->translations->firstWhere('languageCode', 'en')
        ?? $this->translations->first();
}
}