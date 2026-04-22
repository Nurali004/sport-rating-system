<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\Rating;
use App\Models\Season;
use App\Models\Sport;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function validation($request)
    {
        $request->validate([
            'athlete_id' => 'required',
            'season_id' => 'required',
            'sport_id' => 'required',
            'total_points' => 'required',
            'gold_count' => 'required',
            'silver_count' => 'required',
            'bronze_count' => 'required',
            'competitions_count' => 'required',
        ]);
        return $request;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ratings = Rating::paginate(10);
        return view('admin.ratings.index', compact('ratings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sports = Sport::all();
        $seasons = Season::all();
        $athletes = Athlete::all();
        return view('admin.ratings.create', compact('sports', 'seasons', 'athletes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validation($request);
        Rating::create($request->all());
        return redirect()->route('admin.ratings.index')->with('success', 'Rating created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        return view('admin.ratings.show', compact('rating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rating $rating)
    {
        $sports = Sport::all();
        $seasons = Season::all();
        $athletes = Athlete::all();
        return view('admin.ratings.edit', compact('rating', 'sports', 'seasons', 'athletes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        $this->validation($request);
        $rating->update($request->all());
        return redirect()->route('admin.ratings.index')->with('success', 'Rating updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('admin.ratings.index')->with('success', 'Rating deleted successfully.');
    }
}
