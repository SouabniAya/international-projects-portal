<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundingProgrammeTranslation extends Model
{
    protected $table = 'FundingProgrammeTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['programID', 'languageCode', 'programName', 'description'];

    public function programme(): BelongsTo
    {
        return $this->belongsTo(FundingProgramme::class, 'programID', 'programID');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'languageCode', 'languageCode');
    }
}