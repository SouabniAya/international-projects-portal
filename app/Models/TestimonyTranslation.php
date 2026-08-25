<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonyTranslation extends Model
{
    protected $table = 'TestimonyTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = ['testimonyID', 'languageCode', 'content'];

    public function testimony()
    {
        return $this->belongsTo(Testimony::class, 'testimonyID', 'testimonyID');
    }
}