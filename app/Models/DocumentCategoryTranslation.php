<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentCategoryTranslation extends Model
{
    protected $table = 'DocumentCategoryTranslation';
    protected $primaryKey = 'translationID';
    public $timestamps = false;

    protected $fillable = [
        'categoryID',
        'languageCode',
        'categoryName',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'categoryID', 'categoryID');
    }
}