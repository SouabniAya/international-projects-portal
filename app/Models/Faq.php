<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasTranslations;

    protected $table = 'FAQ';
    protected $primaryKey = 'faqID';
    public $timestamps = false;

    public function translations()
    {
        return $this->hasMany(FaqTranslation::class, 'faqID');
    }
}