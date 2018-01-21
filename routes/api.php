<?php

use Illuminate\Http\Request;
use App\Article;
use App\Order;
use App\City;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('choose-tickets', function (Request $request) {
    $tickets = $request->input('tickets');
    $order = Order::create();

    foreach ($tickets as $ticket) {
        $order->tickets()->attach($ticket);
    }

    return $order;
});

Route::get('order/{id}', function ($orderId) {
    $order= Order::with('tickets')->find($orderId);
    $order->wholePrice = 0;



    foreach ($order->tickets as $ticket) {
        $destinationCity = City::with('seasonDiscount')->find($ticket->to_id);
        $seasonDiscount = $destinationCity->seasonDiscount;
        $ticket->discount = $seasonDiscount;
        if ($seasonDiscount != null) {
            $discountValue = $ticket->price / 100 * $seasonDiscount->discount_percentages;
            $ticket->priceWithDiscount = $ticket->price - $discountValue;
            $order->wholePrice += $ticket->priceWithDiscount;

        }
        else {
            $order->wholePrice += $ticket->price;
        }
    }
    return $order;
});
