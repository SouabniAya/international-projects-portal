<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeNewsHighlight extends Model
{
    protected $table = 'homenewshighlight';
    protected $primaryKey = 'highlightID';

    public $timestamps = false;

    protected $fillable = [
        'newsID',
        'displayOrder',
        'addedByUserID',
        'addedAt',
    ];

    public function news()
    {
        return $this->belongsTo(News::class, 'newsID', 'newsID');
    }
}