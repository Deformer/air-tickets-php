<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeasonDiscount extends Model
{
    //

    public function city() {
        return $this->belongsTo('App\City');
    }
}
