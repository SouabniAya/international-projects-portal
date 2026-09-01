<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agreement extends Model
{
    protected $table = 'Agreement';
    protected $primaryKey = 'agreementID';
    public $timestamps = false;

    protected $fillable = [
        'agreementType', 'signatureDate', 'startDate', 'endDate', 'status',
        'partnerID', 'publicationStatus', 'publishedAt', 'scheduledAt',
        'publishedByUserID',
    ];

    protected $casts = [
        'signatureDate' => 'date',
        'startDate' => 'date',
        'endDate' => 'date',
        'publishedAt' => 'datetime',
        'scheduledAt' => 'datetime',
    ];

    // ------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partnerID', 'partnerID');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(AgreementTranslation::class, 'agreementID', 'agreementID');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'publishedByUserID', 'userID');
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'AgreementDocument', 'agreementID', 'documentID');
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

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $term
            ? $query->whereHas('translations', fn (Builder $q) => $q->where('title', 'like', "%{$term}%"))
                ->orWhereHas('partner', fn (Builder $q) => $q->where('partnerName', 'like', "%{$term}%"))
            : $query;
    }

    // ------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------

    public function translation(?string $locale = null): ?AgreementTranslation
    {
        $locale ??= app()->getLocale();

        return $this->translations->firstWhere('languageCode', $locale)
            ?? $this->translations->firstWhere('languageCode', 'en')
            ?? $this->translations->first();
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => 'Active',
            'expired' => 'Expired',
            default => ucfirst((string) $this->status),
        };
    }
}
