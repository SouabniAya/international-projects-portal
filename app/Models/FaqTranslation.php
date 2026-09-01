<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqTranslation extends Model
{
    protected $table = 'FAQTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['faqID', 'languageCode', 'question', 'answer'];

    public function faq()
    {
        return $this->belongsTo(Faq::class, 'faqID');
    }
}