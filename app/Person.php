<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    protected $fillable = ["name", "age", "gender", "passport_series", "passport_number"];

    public function orders() {
        $this->hasMany('App\Order', 'person_id');
    }
}
