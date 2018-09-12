<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    protected $fillable = [
        'name',
        'role_type',
        'dep_id',
    ];
}
