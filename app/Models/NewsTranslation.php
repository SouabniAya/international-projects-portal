<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model
{
    protected $table = 'NewsTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['newsID', 'languageCode', 'title', 'content'];
}