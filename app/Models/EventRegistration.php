<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    protected $table = 'EventRegistration';
    protected $primaryKey = 'registrationID';
    public $timestamps = false;

    protected $fillable = [
        'eventID', 'fullName', 'email', 'phone', 'subjectCode', 'message',
        'consent', 'submissionDate', 'status', 'handledByUserID',
    ];

    protected $casts = [
        'consent' => 'boolean',
        'submissionDate' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'eventID', 'eventID');
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handledByUserID', 'userID');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(ContactSubjectRouting::class, 'subjectCode', 'subjectCode');
    }
}
