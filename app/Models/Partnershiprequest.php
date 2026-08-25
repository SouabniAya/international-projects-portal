<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipRequest extends Model
{
    protected $table = 'PartnershipRequest';
    protected $primaryKey = 'requestID';
    public $timestamps = false;

    protected $fillable = [
        'requesterName', 'organizationName', 'email', 'phone', 'country',
        'message', 'submissionDate', 'status', 'handledByUserID',
    ];

    protected $casts = [
        'submissionDate' => 'datetime',
    ];

    public function countryModel()
    {
        return $this->belongsTo(Country::class, 'country', 'countryCode');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handledByUserID', 'userID');
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'PartnershipRequestDocument', 'requestID', 'documentID');
    }
}