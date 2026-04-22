<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function list()
    {
        $competitions = Competition::all();
        return view('frontend.competitions.list', compact('competitions'));
    }

    public function show($id){
        $competition = Competition::findOrFail($id);
        return view('frontend.competitions.show', compact('competition'));
    }
}
