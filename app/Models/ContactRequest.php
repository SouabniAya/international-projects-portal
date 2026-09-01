<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    protected $table = 'ContactRequest';
    protected $primaryKey = 'requestID';
    public $timestamps = false;

    protected $fillable = [
        'fullName', 'email', 'phone', 'requesterCategoryCode',
        'subjectCode', 'message', 'submissionDate', 'status', 'handledByUserID',
    ];

    protected $casts = [
        'submissionDate' => 'datetime',
    ];

    public function subject()
    {
        return $this->belongsTo(ContactSubjectRouting::class, 'subjectCode', 'subjectCode');
    }

    public function requesterCategory()
    {
        return $this->belongsTo(RequesterCategory::class, 'requesterCategoryCode', 'categoryCode');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handledByUserID', 'userID');
    }
}