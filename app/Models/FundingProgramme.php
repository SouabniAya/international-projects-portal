<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FundingProgramme extends Model
{
    protected $table = 'FundingProgramme';
    protected $primaryKey = 'programID';
    public $timestamps = false;

    protected $fillable = ['officialWebsite'];

    public function translations(): HasMany
    {
        return $this->hasMany(FundingProgrammeTranslation::class, 'programID', 'programID');
    }

    public function calls(): HasMany
    {
        return $this->hasMany(CallForProposal::class, 'programID', 'programID');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'programID', 'programID');
    }

    public function documents(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'FundingProgrammeDocument', 'programID', 'documentID');
    }

    public function translation(?string $locale = null): ?FundingProgrammeTranslation
    {
        $locale ??= app()->getLocale();

        return $this->translations->firstWhere('languageCode', $locale)
            ?? $this->translations->firstWhere('languageCode', 'en')
            ?? $this->translations->first();
    }
}