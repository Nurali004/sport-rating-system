<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\Sport;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seasons = Season::paginate(10);
        return view('admin.seasons.index', compact('seasons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sports = Sport::all();
        return view('admin.seasons.create', compact('sports'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season)
    {
        $sports = Sport::all();
        return view('admin.seasons.show', compact('season', 'sports'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Season $season)
    {
        $sports = Sport::all();
        return view('admin.seasons.edit', compact('season', 'sports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Season $season)
    {
        $request->validate([
            'name' => 'required',
            'sport_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'year_start' => 'required',
            'year_end' => 'required',
            'is_active' => 'required'
        ]);
        $season->update($request->all());
        return redirect()->route('admin.seasons.index')->with('success', 'Season updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Season $season)
    {
        $season->delete();
        return redirect()->route('seasons.index')->with('success', 'Season deleted successfully');
    }
}
