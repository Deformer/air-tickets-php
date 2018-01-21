<?php

use App\Http\Controllers\CountryController as CountryCtrl;
use App\Http\Controllers\FlightController as FlightCtrl;
use Illuminate\Http\Request;
use App\City;
use App\Order;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $countries = CountryCtrl::index();
    $flights = FlightCtrl::index();
    return view('ticket-select-first-page', ['countries' => $countries, 'flights' => $flights]);
});

Route::get('/hello', function () {
    return view('hello', ['name' => 'James']);
});

Route::get('/available-flights', function (Request $request){
    $from = $request->input('from');
    $to = $request->input('to');
    $daterange = $request->input('daterange');

    $dates = explode('-', $daterange);
    $startDate = trim($dates[0]);
    $endDate = trim($dates[1]);

    $routes = FlightCtrl::allFlightsInRange($from, $to, $startDate, $endDate);
    $fromCity = City::find($from);
    $toCity = City::find($to);
    return view('available-flights', ['routes' => $routes, 'fromCity' => $fromCity, 'toCity' => $toCity]);
});

Route::get('/order-page/{orderId}', function ($orderId) {
    $order= Order::with('tickets')->find($orderId);
    $order->wholePrice = 0;
    $order->wholePriceWithDiscounts = 0;
    $order->hasDiscounts = False;


    foreach ($order->tickets as $ticket) {
        $destinationCity = City::with('seasonDiscount')->find($ticket->to_id);
        $seasonDiscount = $destinationCity->seasonDiscount;
        $ticket->discount = $seasonDiscount;
        if ($seasonDiscount != null) {
            $discountValue = $ticket->price / 100 * $seasonDiscount->discount_percentages;
            $ticket->priceWithDiscount = $ticket->price - $discountValue;
            $order->wholePriceWithDiscounts += $ticket->priceWithDiscount;
            $order->hasDiscounts = True;
            $ticket->hasDiscount = True;
        }
        else {
            $ticket->hasDiscount = False;
            $order->wholePrice += $ticket->price;
            $order->wholePriceWithDiscounts += $ticket->price;
        }
    }

    return view('order-page', ['order' => $order]);
});
