<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentCategoryTranslation extends Model
{
    protected $table = 'DocumentCategoryTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;
}