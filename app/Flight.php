<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    //
    protected $fillable = ['airline', 'number_of_tikcets', 'price', 'class', 'time_start', 'time_end'];

    public function aircraft() {
        return $this->belongsTo('App\Aircraft', 'aircraft_id');
    }

    public function from() {
        return $this->belongsTo('App\City', 'from_id');
    }

    public function to() {
        return $this->belongsTo('App\City', 'to_id');
    }

    public function scopeByCityId($query, $cityId) {
        return $query->where('from_id', '=', $cityId);
    }

    public function scopeMoreThanFromDate($query, \DateTime $startDate) {
        return $query->where('time_start', '>', $startDate);
    }
}
