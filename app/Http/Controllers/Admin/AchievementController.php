<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Athlete;
use App\Models\Competition;
use App\Models\Season;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $achievements = Achievement::paginate(10);
        return view('admin.achievements.index', compact('achievements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $athletes = Athlete::all();
        $competitions = Competition::all();
        $seasons = Season::all();
        $medals = ['oltin', 'kumush', 'bronza'];
        return view('admin.achievements.create', compact('athletes', 'competitions', 'seasons', 'medals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'athlete_id' => 'required',
            'competition_id' => 'required',
            'season_id' => 'required',
            'medal' => 'required',
        ]);
        Achievement::create($request->all());
        return redirect()->route('admin.achievements.index')->with('success', 'Achievement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Achievement $achievement)
    {
        return view('admin.achievements.show', compact('achievement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achievement $achievement)
    {
        $athletes = Athlete::all();
        $competitions = Competition::all();
        $seasons = Season::all();
        $medals = [ 1=> 'gold', 2 => 'silver',  3=> 'bronze'];
        return view('admin.achievements.edit', compact('achievement', 'athletes', 'competitions', 'seasons', 'medals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'athlete_id' => 'required',
            'competition_id' => 'required',
            'season_id' => 'required',
            'place' => 'required',
            'medal' => 'required',
            'weight_category' => 'required',
            'points' => 'required',
        ]);
        $achievement->update($request->all());
        return redirect()->route('admin.achievements.index')->with('success', 'Achievement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();
        return redirect()->route('admin.achievements.index')->with('success', 'Achievement deleted successfully.');
    }
}
