<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasTranslations;

    protected $table = 'Event';
    protected $primaryKey = 'eventID';
    public $timestamps = false;

    public function translations()
    {
        return $this->hasMany(EventTranslation::class, 'eventID');
    }
}