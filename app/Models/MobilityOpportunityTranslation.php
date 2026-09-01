<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobilityOpportunityTranslation extends Model
{
    protected $table = 'MobilityOpportunityTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = [
        'mobilityID',
        'languageCode',
        'title',
        'conditions',
        'applicationProcess',
        'selectionCriteria',
    ];
}