<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $table = 'Project';
    protected $primaryKey = 'projectID';
    public $timestamps = false;

    protected $fillable = [
        'acronym', 'logo', 'projectReference', 'coordinator', 'schoolRole',
        'startDate', 'endDate', 'projectStatus', 'website', 'featured',
        'publicationStatus', 'publishedAt', 'scheduledAt', 'programID',
        'publishedByUserID', 'countryCode',
    ];

    protected $casts = [
        'startDate' => 'date',
        'endDate' => 'date',
        'featured' => 'boolean',
        'publishedAt' => 'datetime',
        'scheduledAt' => 'datetime',
    ];

    // ------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------

    public function translations(): HasMany
    {
        return $this->hasMany(ProjectTranslation::class, 'projectID', 'projectID');
    }

    public function fundingProgramme(): BelongsTo
    {
        return $this->belongsTo(FundingProgramme::class, 'programID', 'programID');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'countryCode', 'countryCode');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'publishedByUserID', 'userID');
    }

    /**
     * Partner institutions involved in this project.
     * partnerRole pivot values: coordinator | associate_partner | funding_partner
     * (confirmed business rule — see Partner::projects() for the inverse).
     */
    public function partners(): BelongsToMany
    {
        return $this->belongsToMany(Partner::class, 'ProjectPartner', 'projectID', 'partnerID')
            ->withPivot('partnerRole');
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'ProjectDocument', 'projectID', 'documentID');
    }

    // ------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('publicationStatus', 'published');
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('projectStatus', $status) : $query;
    }

    public function scopeProgramme(Builder $query, ?int $programID): Builder
    {
        return $programID ? $query->where('programID', $programID) : $query;
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $term
            ? $query->whereHas('translations', fn (Builder $q) => $q->where('title', 'like', "%{$term}%"))
                ->orWhere('acronym', 'like', "%{$term}%")
            : $query;
    }

    // ------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------

    public function translation(?string $locale = null): ?ProjectTranslation
    {
        $locale ??= app()->getLocale();

        return $this->translations->firstWhere('languageCode', $locale)
            ?? $this->translations->firstWhere('languageCode', 'en')
            ?? $this->translations->first();
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->projectStatus) {
            'proposed' => 'Proposed',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            default => ucfirst((string) $this->projectStatus),
        };
    }
}
