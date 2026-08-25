<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class CallForProposal extends Model
{
    protected $table = 'CallForProposal';
    protected $primaryKey = 'proposalID';
    public $timestamps = false;

    protected $fillable = [
        'financingOrganism', 'actionType', 'fundingType', 'budget',
        'financingRate', 'openingDate', 'deadline', 'linkToOfficialSource',
        'status', 'publicationStatus', 'publishedAt', 'scheduledAt',
        'programID', 'publishedByUserID', 'contact',
    ];

    protected $casts = [
        'openingDate'  => 'date',
        'deadline'     => 'date',
        'budget'       => 'decimal:2',
        'publishedAt'  => 'datetime',
        'scheduledAt'  => 'datetime',
    ];

    // ------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------

    public function fundingProgramme(): BelongsTo
    {
        return $this->belongsTo(FundingProgramme::class, 'programID', 'programID');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(CallForProposalTranslation::class, 'proposalID', 'proposalID');
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'CallDocument', 'proposalID', 'documentID')
            ->withPivot([]);
    }

    public function thematicAreas(): BelongsToMany
    {
        return $this->belongsToMany(ThematicArea::class, 'ClassifiedAs', 'proposalID', 'areaID');
    }

    public function eligibleCountries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'EligibleIn', 'proposalID', 'countryCode', 'countryCode', 'countryCode');
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
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeProgramme(Builder $query, ?int $programID): Builder
    {
        return $programID ? $query->where('programID', $programID) : $query;
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $term
            ? $query->whereHas('translations', fn (Builder $q) => $q->where('title', 'like', "%{$term}%"))
            : $query;
    }

    // ------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------

    /**
     * Best-matching translation for a locale, falling back to English
     * then to whatever translation is loaded.
     */
    public function translation(?string $locale = null): ?CallForProposalTranslation
    {
        $locale ??= app()->getLocale();

        return $this->translations->firstWhere('languageCode', $locale)
            ?? $this->translations->firstWhere('languageCode', 'en')
            ?? $this->translations->first();
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open'         => 'Open',
            'upcoming'     => 'Upcoming',
            'closing_soon' => 'Closing Soon',
            'closed'       => 'Closed',
            default        => ucfirst((string) $this->status),
        };
    }

    public function getBudgetLabelAttribute(): ?string
    {
        return $this->budget !== null ? '€' . number_format((float) $this->budget, 0, ',', ',') : null;
    }
}