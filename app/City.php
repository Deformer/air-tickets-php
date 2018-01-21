<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $fillable = ['name'];

    public function country() {
        return $this->belongsTo('App\Country');
    }

    public function seasonDiscount() {
        return $this->hasOne('App\SeasonDiscount', 'city_id');
    }
}
