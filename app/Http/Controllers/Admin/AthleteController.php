<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\Region;
use App\Models\Sport;
use Illuminate\Http\Request;

class AthleteController extends Controller
{
    public function validation($request)
    {
        return $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'region_id' => 'required',
            'sport_id' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'weight_category' => 'required',
            'coach_name' => 'required|string|max:255',
            'club_name' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'rating_score' => 'required|integer|min:0',
            'rank_position' => 'required|integer|min:0',
        ]);
    }

    public function image($request)
    {
        $requestData = [];
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/athletes/'), $imageName);
            $requestData['photo'] = $imageName;
        }
        return $requestData;
    }

    public function images($request)
    {
        $requestData = [];
        if ($request->hasFile('cover_photo')) {
            $coverImage = $request->file('cover_photo');
            $coverImageNames = [];
            foreach ($coverImage as $image) {
                $imageName = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/athletes/'), $imageName);
                $coverImageNames[] = $imageName;
            }
            $requestData['cover_photo'] = json_encode($coverImageNames);
        }
        return $requestData;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $athletes = Athlete::paginate(10);
        return view('admin.athletes.index', compact('athletes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sports = Sport::all();
        $regions = Region::all();
        return view('admin.athletes.create', compact('sports', 'regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validation($request);
        $requestData = $request->except(['cover_photo', 'photo']);
        $requestData['photo'] = $this->image($request);
        $requestData['cover_photo'] = $this->images($request);
        Athlete::create($requestData);
        return redirect()->route('admin.athletes.index')->with('success', 'Athlete created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Athlete $athlete)
    {
        $photos = $athlete->cover_photo;
        if (is_string($photos)) {
            $photos = json_decode($photos, true);
        }
        return view('admin.athletes.show', compact('athlete', 'photos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Athlete $athlete)
    {
        $regions = Region::all();
        $sports = Sport::all();
        return view('admin.athletes.edit', compact('athlete', 'regions', 'sports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Athlete $athlete)
    {
        $this->validation($request);
        $requestData = $request->except(['cover_photo', 'photo']);
        $requestData = array_merge($requestData, $this->image($request));
        $requestData = array_merge($requestData, $this->images($request));
        $athlete->update($requestData);
        return redirect()->route('admin.athletes.index')->with('success', 'Athlete updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Athlete $athlete)
    {
        $athlete->delete();
        return redirect()->route('admin.athletes.index')->with('success', 'Athlete deleted successfully');
    }
}
