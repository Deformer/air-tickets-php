<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['person_id'];

    public function tickets() {
        return $this->belongsToMany('App\Flight', 'order_ticket', 'order_id', 'ticket_id');
    }

    public function person() {
        return $this->belongsTo('App\Person', 'person_id');
    }
}
