<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequesterCategoryTranslation extends Model
{
    protected $table = 'RequesterCategoryTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['categoryCode', 'languageCode', 'categoryLabel'];

    public function category()
    {
        return $this->belongsTo(RequesterCategory::class, 'categoryCode', 'categoryCode');
    }
}