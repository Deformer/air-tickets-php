<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //

    public function orders() {
        $this->hasMany('App\Order', 'person_id');
    }
}
