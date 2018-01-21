<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $fillable = ['name', 'abbreviation'];

    public function cities() {
        return $this->hasMany('App\City', 'country_id');
    }
}
