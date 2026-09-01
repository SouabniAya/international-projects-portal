<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubjectRoutingTranslation extends Model
{
    protected $table = 'ContactSubjectRoutingTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['subjectCode', 'languageCode', 'subjectLabel'];

    public function subject()
    {
        return $this->belongsTo(ContactSubjectRouting::class, 'subjectCode', 'subjectCode');
    }
}