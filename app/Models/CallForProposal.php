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


    // ------------------------------------------------------------
    // Mass assignable fields
    // ------------------------------------------------------------

    protected $fillable = [
        'programID',
        'openingDate',
        'deadline',
        'status',
        'financingRate',
        'budget',
        'linkToOfficialSource',
        'publicationStatus',
        'publishedAt',
        'publishedByUserID',
        'scheduledAt',
    ];


    // ------------------------------------------------------------
    // Casts
    // ------------------------------------------------------------

    protected $casts = [
        'openingDate' => 'date',
        'deadline' => 'date',
        'budget' => 'decimal:2',
        'financingRate' => 'decimal:2',
        'publishedAt' => 'datetime',
        'scheduledAt' => 'datetime',
    ];


    // ------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------

    public function fundingProgramme(): BelongsTo
    {
        return $this->belongsTo(
            FundingProgramme::class,
            'programID',
            'programID'
        );
    }


    public function translations(): HasMany
    {
        return $this->hasMany(
            CallForProposalTranslation::class,
            'proposalID',
            'proposalID'
        );
    }


    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(
            Document::class,
            'CallDocument',
            'proposalID',
            'documentID'
        )->withPivot([]);
    }


    public function thematicAreas(): BelongsToMany
    {
        return $this->belongsToMany(
            ThematicArea::class,
            'ClassifiedAs',
            'proposalID',
            'areaID'
        );
    }


    public function eligibleCountries(): BelongsToMany
    {
        return $this->belongsToMany(
            Country::class,
            'EligibleIn',
            'proposalID',
            'countryCode',
            'countryCode',
            'countryCode'
        );
    }


    public function publisher(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'publishedByUserID',
            'userID'
        );
    }


    // ------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(
            'publicationStatus',
            'published'
        );
    }


    public function scopeStatus(
        Builder $query,
        ?string $status
    ): Builder {
        return $status
            ? $query->where('status', $status)
            : $query;
    }


    public function scopeProgramme(
        Builder $query,
        ?int $programID
    ): Builder {
        return $programID
            ? $query->where('programID', $programID)
            : $query;
    }


    public function scopeSearch(
        Builder $query,
        ?string $term
    ): Builder {
        return $term
            ? $query->whereHas(
                'translations',
                fn (Builder $q) =>
                    $q->where(
                        'title',
                        'like',
                        "%{$term}%"
                    )
            )
            : $query;
    }


    // ------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------

    /**
     * Get the best matching translation.
     *
     * Priority:
     * 1. Current application locale
     * 2. English
     * 3. First available translation
     */
    public function translation(
        ?string $locale = null
    ): ?CallForProposalTranslation {

        $locale ??= app()->getLocale();

        return $this->translations->firstWhere(
            'languageCode',
            $locale
        )
        ?? $this->translations->firstWhere(
            'languageCode',
            'en'
        )
        ?? $this->translations->first();
    }


    // ------------------------------------------------------------
    // Accessors
    // ------------------------------------------------------------

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {

            'open' =>
                'Open',

            'upcoming' =>
                'Upcoming',

            'closing_soon' =>
                'Closing Soon',

            'closed' =>
                'Closed',

            default =>
                ucfirst((string) $this->status),
        };
    }


    public function getBudgetLabelAttribute(): ?string
    {
        return $this->budget !== null
            ? '€' . number_format(
                (float) $this->budget,
                0,
                ',',
                ','
            )
            : null;
    }
}