<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class listings extends Model
{
    protected $fillable = [
        'dep_id',
        'patient_name',
        'in_date',
        'quota_id',
        'phone',
        'signed_off'
    ];
}
