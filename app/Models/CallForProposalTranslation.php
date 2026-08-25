<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallForProposalTranslation extends Model
{
    protected $table = 'CallForProposalTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = [
        'proposalID', 'languageCode', 'title', 'description',
        'objectives', 'eligibleBeneficiaries',
    ];

    public function call(): BelongsTo
    {
        return $this->belongsTo(CallForProposal::class, 'proposalID', 'proposalID');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'languageCode', 'languageCode');
    }
}