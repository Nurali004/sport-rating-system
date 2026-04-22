<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sports = Sport::paginate(7);
        return view('admin.sports.index', compact('sports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_uz' => 'required',
            'name_ru' => 'required',
            'name_en' => 'required',
            'image' => 'required|image',
        ]);
        $requestData = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time(). uniqid(). '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/sports/'), $imageName);
            $requestData['image'] = $imageName;
        }
        $requestData['slug'] = Str::slug($request->name_en);
        Sport::create($requestData);
        return redirect()->route('admin.sports.index')->with('success', 'Sport created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sport $sport)
    {
        return view('admin.sports.show', compact('sport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sport $sport)
    {
        return view('admin.sports.edit', compact('sport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sport $sport)
    {
        $request->validate(['name_uz' => 'required', 'name_ru' => 'required','name_en' => 'required'
        ]);
        $requestData = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/sports/'), $imageName);
            $requestData['image'] = $imageName;
        }
        $requestData['slug'] = Str::slug($request->name_en);
        $sport->update($requestData);
        return redirect()->route('admin.sports.index')->with('success', 'Sport updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {
        $sport->delete();
        return redirect()->route('admin.sports.index')->with('success', 'Sport deleted successfully');
    }
}
