<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flight;
use App\Helpers\FlightFinder;
class FlightController extends Controller
{
    //

    public static function index() {
        return Flight::with(['from', 'to', 'aircraft'])->get();
    }

    public static function getFlightFromByDate($cityId, $date) {
        return Flight::byCityId($cityId)->moreThanFromDate(new \DateTime($date))->with(['from', 'to', 'aircraft'])->get();
    }

    public static function allFlightsInRange(int $fromCityId, int $toCityId, string $startDate, string $endDate){
        $flightFinder = new FlightFinder();
        return $flightFinder->findFligths($fromCityId, $toCityId, $startDate, $endDate);
    }
}
