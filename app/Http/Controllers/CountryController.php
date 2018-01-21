<?php

namespace App\Http\Controllers;
use App\Country;

use Illuminate\Http\Request;

class CountryController extends Controller
{
    //
    public static function index() {
        return Country::with('cities')->get();
    }

    public function getById(Country $country) {
        return $country::with('cities')->get();
    }

    public function cities(Country $country) {
        return $country->cities;
    }
}
