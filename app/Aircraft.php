<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    //
    protected $fillable = ['number_of_seats', 'name'];

    public function flights () {
        return $this->hasMany('App/Flight', 'aircraft_id');
    }
}
