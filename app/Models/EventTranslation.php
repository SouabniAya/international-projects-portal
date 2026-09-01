<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTranslation extends Model
{
    protected $table = 'EventTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;
}