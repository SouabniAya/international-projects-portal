<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerTranslation extends Model
{
    protected $table = 'PartnerTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = [
        'partnerID',
        'languageCode',
        'presentation',
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partnerID', 'partnerID');
    }
}