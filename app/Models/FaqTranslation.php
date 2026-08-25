<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqTranslation extends Model
{
    protected $table = 'FAQTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    public function faq()
    {
        return $this->belongsTo(Faq::class, 'faqID');
    }
}