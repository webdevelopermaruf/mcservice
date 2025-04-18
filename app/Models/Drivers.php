<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drivers extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'address', 'fleet', 'photo', 'driving_license',
    ];
}
