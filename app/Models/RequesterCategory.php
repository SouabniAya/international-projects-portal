<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequesterCategory extends Model
{
    protected $table = 'RequesterCategory';
    protected $primaryKey = 'categoryCode';
    public $timestamps = false;

    protected $fillable = ['categoryCode'];

    public function translations()
    {
        return $this->hasMany(RequesterCategoryTranslation::class, 'categoryCode', 'categoryCode');
    }
}