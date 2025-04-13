<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passengers extends Model
{
    protected $fillable = ['name', 'emails', 'phone', 'address', 'booked'];
}
