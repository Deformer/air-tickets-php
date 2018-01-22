<?php
/**
 * Created by PhpStorm.
 * User: sergejbelan
 * Date: 22.01.2018
 * Time: 13:17
 */

namespace App\Helpers;

use App\City;
use App\SeasonDiscount;
use Faker\Provider\DateTime;

class RouteFormat
{
    private static function timeInRoute($route) {
        $firstTicket = $route->tickets[0];
        $lastTicket = $route->tickets[count($route->tickets) - 1];

        $start = new \DateTime($firstTicket->time_start);
        $end = new \DateTime($lastTicket->time_end);
        $timeInRoute = $end->diff($start);

        return $timeInRoute->format('%H часов %i минут');
    }

    public static function routeStartAndDestination($route) {
        $firstTicket = $route->tickets[0];
        $lastTicket = $route->tickets[count($route->tickets) - 1];

        $route->fromCity = $firstTicket->from;
        $route->toCity = $lastTicket->to;

        return $route;
    }

    public static function calculateDiscountsForTickets($tickets) {
        foreach ($tickets as $ticket) {
            $destinationCity = City::with('seasonDiscount')->find($ticket->to_id);
            $seasonDiscount = $destinationCity->seasonDiscount;
            $ticket->discount = $seasonDiscount;
            if ($seasonDiscount != null) {
                $discountValue = $ticket->price / 100 * $seasonDiscount->discount_percentages;
                $ticket->priceWithDiscount = $ticket->price - $discountValue;
                $ticket->hasDiscount = True;
            }
            else {
                $ticket->hasDiscount = False;
            }
        }
        return $tickets;
    }

    public static function calculateDiscountsForRoute($route) {
        $route->wholePrice = 0;
        $route->wholePriceWithDiscounts = 0;
        $route->hasDiscounts = False;
        $route->wholeTimeInRoute = RouteFormat::timeInRoute($route);
        $route->ticketsNumber = count($route->tickets);
        $route = RouteFormat::routeStartAndDestination($route);

        foreach ($route->tickets as $flight) {
            $destinationCity = City::with('seasonDiscount')->find($flight->to_id);
            $seasonDiscount = $destinationCity->seasonDiscount;
            $flight->discount = $seasonDiscount;
            if ($seasonDiscount != null) {
                $discountValue = $flight->price / 100 * $seasonDiscount->discount_percentages;
                $flight->priceWithDiscount = $flight->price - $discountValue;
                $flight->hasDiscount = True;
                $route->wholePriceWithDiscounts += $flight->priceWithDiscount;
                $route->hasDiscounts = True;
            }
            else {
                $flight->hasDiscount = False;
                $route->wholePrice += $flight->price;
                $route->wholePriceWithDiscounts += $flight->price;
            }
        }
        return $route;
    }

}