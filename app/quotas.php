<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class quotas extends Model
{
    protected $fillable = [
        'dep_id',
        'qtty',
        'date_start',
        'date_end'
    ];
}
