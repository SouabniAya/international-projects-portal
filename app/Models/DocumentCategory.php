<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    use HasTranslations;

    protected $table = 'DocumentCategory';
    protected $primaryKey = 'categoryID';
    public $timestamps = false;

    public function translations()
    {
        return $this->hasMany(DocumentCategoryTranslation::class, 'categoryID');
    }
}