<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobilityDocument extends Model
{
    protected $table = 'MobilityDocument';
    public $timestamps = false;
    public $incrementing = false;

    public function document()
    {
        return $this->belongsTo(Document::class, 'documentID');
    }
}