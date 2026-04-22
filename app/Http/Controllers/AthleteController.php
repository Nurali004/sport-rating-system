<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Athlete;
use App\Models\Rating;
use App\Models\Region;
use App\Models\Sport;
use Illuminate\Http\Request;

class AthleteController extends Controller
{
    public function list()
    {
        $athletes = Athlete::all();
        $sports = Sport::all();
        $regions = Region::all();
        return view('frontend.athletes.list', compact('athletes', 'sports', 'regions'));
    }

    public function show($id)
    {
        $athlete = Athlete::findOrFail($id);
        $photos = $athlete->cover_photo;
        if (is_string($photos)) {
            $photos = json_decode($photos, true);
        }
        $achievements = Achievement::where('athlete_id', $id)->get();
        $ratings = Rating::where('athlete_id', $id)->get();
        return view('frontend.athletes.show', compact('athlete', 'photos', 'achievements', 'ratings'));
    }
}
