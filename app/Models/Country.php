<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasTranslations;

    protected $table = 'Country';
    protected $primaryKey = 'countryCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function translations()
    {
        return $this->hasMany(CountryTranslation::class, 'countryCode', 'countryCode');
    }
}