<?php

namespace App\Http\Controllers;

use App\Models\Contents;
use App\Models\Fleets;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contents = Contents::where('page', '/')->get()->groupBy('section')->map(function ($group) {
            return $group->first(); // Take the first (and only) item from each group
        })->all();
        return view("Home", ["contents" => $contents]);
    }

    public function fleets()
    {
        return view('Fleets');
    }

    public function services()
    {
        return view('Services');
    }

    /**
     * Display the specified resource.
     */
    public function contact()
    {
        return view('Contact');
    }

    /**
     * Vue Page Methods.
     */
    public function booking(Request $request)
    {
        $fleets = Fleets::all();
        return Inertia::render('Booking',['fleets' => $fleets, 'query'=>$request->all()]);
    }

}
