<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'Document';
    protected $primaryKey = 'documentID';
    public $timestamps = false;

    protected $fillable = [
        'title', 'documentType', 'description', 'version', 'publicationDate',
        'expirationDate', 'format', 'size', 'visibilityLevel', 'file',
        'externalLink', 'categoryID', 'languageCode', 'uploadedByUserID',
        'replacedByDocumentID', 'publishedAt', 'scheduledAt', 'publishedByUserID',
        'publicationStatus',
    ];

    protected $casts = [
        'publicationDate' => 'date',
        'expirationDate'  => 'date',
        'size'            => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'categoryID', 'categoryID');
    }

    public function replacedBy()
    {
        return $this->belongsTo(Document::class, 'replacedByDocumentID', 'documentID');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploadedByUserID', 'userID');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publishedByUserID', 'userID');
    }

    /**
     * Human-readable file size, e.g. "2.4 MB".
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return round($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }

    public function scopeVisible($query)
    {
        return $query->where('publicationStatus', 'published')
            ->where(function ($q) {
                $q->where('visibilityLevel', 'public');
                if (auth()->check()) {
                    $q->orWhere('visibilityLevel', 'restricted');
                }
            });
    }
}