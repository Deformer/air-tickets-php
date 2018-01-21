<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    public function tickets() {
        return $this->belongsToMany('App\Flight', 'order_ticket', 'order_id', 'ticket_id');
    }
}
