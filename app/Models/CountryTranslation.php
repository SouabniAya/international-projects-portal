<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    protected $table = 'CountryTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;
}