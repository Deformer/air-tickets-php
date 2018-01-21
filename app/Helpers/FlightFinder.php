<?php
/**
 * Created by PhpStorm.
 * User: sergejbelan
 * Date: 16.01.2018
 * Time: 16:07
 */

namespace App\Helpers;
use App\Flight;
use App\Http\Controllers\FlightController;
class FlightFinder
{
    private $routes;

    function __construct(){
        $this->routes = [];
    }
    public function findRoute($flight, $dest, $route, $endDate) {
        if ($flight->to_id == $dest && $flight->time_end <= $endDate) {
            array_push($this->routes, $route);
        } else {
            $vertexes = FlightController::getFlightFromByDate($flight->to_id, $flight->time_end);
            foreach ($vertexes as $vertex) {
                $newRoute = $route;
                array_push($newRoute, $vertex);
                $this::findRoute($vertex, $dest, $newRoute, $endDate);
            }
        }
    }

    public function findFligths($fromCityId, $toCityId, $startDate, $endDate) {
        $startFlights = FlightController::getFlightFromByDate($fromCityId, $startDate);
        $routes = [];
        foreach ($startFlights as $flight) {
            $this::findRoute($flight, $toCityId, [$flight], $endDate);
        }
        return $this->routes;
    }
}