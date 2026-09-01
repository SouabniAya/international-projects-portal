<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasTranslations;

    protected $table = 'News';
    protected $primaryKey = 'newsID';
    public $timestamps = false;

    public function translations()
    {
        return $this->hasMany(NewsTranslation::class, 'newsID');
    }
}