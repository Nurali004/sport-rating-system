<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Region;
use App\Models\Sport;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function list()
    {
        $ratings = Rating::all();
        $sports = Sport::all();
        $regions = Region::all();
        return view('frontend.ratings.list', compact('ratings', 'sports', 'regions'));
    }
}
