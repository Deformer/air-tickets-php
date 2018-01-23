<?php

use Illuminate\Http\Request;
use App\Article;
use App\Order;
use App\City;
use App\Http\Controllers\CountryController as CountryCtrl;
use App\Http\Controllers\FlightController as FlightCtrl;
use App\Aircraft;
use App\Person;

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
    $personId = $request->input('personId');
    $order = Order::create(['person_id' => $personId]);

    foreach ($tickets as $ticket) {
        $order->tickets()->attach($ticket);
    }

    return $order;
});

Route::post('person', function (Request $request) {
    $personData = $request->input('person');
    $person = Person::create($personData);

    return $person;
});

Route::post('flight', function (Request $request) {
    $countries = CountryCtrl::index();
    $flights = FlightCtrl::index();
    $aircrafts = Aircraft::get();

    return view('admin-add-airline', ['countries' => $countries, 'aircrafts' => $aircrafts]);
});
