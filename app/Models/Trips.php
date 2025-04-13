<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trips extends Model
{
    public function passenger()
    {
        return $this->hasOne(Passengers::class, 'id', 'passengers_id');
    }
    public function fleet()
    {
        return $this->hasOne(Fleets::class, 'id', 'fleets_id');
    }
}
