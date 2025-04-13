<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fleets extends Model
{
    protected $table = 'fleets';

    protected $fillable = [
        'name',
        'image',
        'description',
        'passengers',
        'luggages',
        'min_pay',
        'min_distances',
        'after_min',
        'airport_charge',
        'min_hours',
        'min_hours_pay',
        'after_min_hours',
    ];

}
