<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubjectRouting extends Model
{
    protected $table = 'ContactSubjectRouting';
    protected $primaryKey = 'subjectCode';
    public $timestamps = false;

    protected $fillable = ['roleID'];

    public function translations()
    {
        return $this->hasMany(ContactSubjectRoutingTranslation::class, 'subjectCode', 'subjectCode');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'roleID', 'roleID');
    }
}