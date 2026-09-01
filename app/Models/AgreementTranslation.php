<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementTranslation extends Model
{
    protected $table = 'AgreementTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['agreementID', 'languageCode', 'title'];

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class, 'agreementID', 'agreementID');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'languageCode', 'languageCode');
    }
}
