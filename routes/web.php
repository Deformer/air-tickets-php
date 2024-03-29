<?php

use App\Http\Controllers\CountryController as CountryCtrl;
use App\Http\Controllers\FlightController as FlightCtrl;
use Illuminate\Http\Request;
use App\City;
use App\Order;
use App\SeasonDiscount;
use App\Helpers\RouteFormat;
use App\Aircraft;
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

Route::get('/admin', function () {
    $countries = CountryCtrl::index();
    $flights = FlightCtrl::index();
    $aircrafts = Aircraft::get();

    return view('admin-add-airline', ['countries' => $countries, 'aircrafts' => $aircrafts]);
});

Route::get('/', function () {
    return view('home');
});

Route::get('/registration', function () {
    return view('user-registration-page');
});

Route::get('/select-tickets', function () {
    $countries = CountryCtrl::index();
    $flights = FlightCtrl::index();
    $discounts = SeasonDiscount::with('city')->get();
    $flights = RouteFormat::calculateDiscountsForTickets($flights);

    return view('ticket-select-first-page', ['countries' => $countries, 'flights' => $flights, 'discounts' => $discounts]);
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
    foreach ($routes as $route) {
        $route = RouteFormat::calculateDiscountsForRoute($route);
    }
    return view('available-flights', ['routes' => $routes, 'fromCity' => $fromCity, 'toCity' => $toCity]);
});

Route::get('/order-page/{orderId}', function ($orderId) {
    $order = Order::with('tickets')->find($orderId);
    $order = RouteFormat::calculateDiscountsForRoute($order);

    return view('order-page', ['order' => $order]);
});
