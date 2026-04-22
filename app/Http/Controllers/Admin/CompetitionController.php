<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Season;
use App\Models\Sport;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function validation($request)
    {
        $request->validate([
            'sport_id' => 'required',
            'season_id' => 'required',
            'title_uz' => 'required',
            'title_ru' => 'required',
            'title_en' => 'required',
            'level' => 'required',
            'organizer' => 'required',
            'description_uz' => 'required',
            'description_ru' => 'required',
            'description_en' => 'required',
            'participants_count' => 'required',
            'status' => 'required',
            'rating' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'location_uz' => 'required',
            'location_ru' => 'required',
            'location_en' => 'required',
            'location_country' => 'required',

        ]);
        return $request;
    }

    public function image($request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/competitions/'), $imageName);
            return $imageName;
        }
        return null;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competitions = Competition::paginate(10);
        return view('admin.competitions.index', compact('competitions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sports = Sport::all();
        $seasons = Season::all();
        return view('admin.competitions.create', compact('sports', 'seasons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validation($request);
        $requestData = $request->except('image');
        $requestData['image'] = $this->image($request);
        Competition::create($requestData);
        return redirect()->route('admin.competitions.index')->with('success', 'Competition created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Competition $competition)
    {
        return view('admin.competitions.show', compact('competition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competition $competition)
    {
        $sports = Sport::all();
        $seasons = Season::all();
        return view('admin.competitions.edit', compact('competition', 'sports', 'seasons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competition $competition)
    {
        $this->validation($request);
        $requestData = $request->except('image');
        if ($request->hasFile('image')) {
        $requestData['image'] = $this->image($request);
        }
        $competition->update($requestData);
        return redirect()->route('admin.competitions.index')->with('success', 'Competition updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
