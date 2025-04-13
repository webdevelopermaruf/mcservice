<?php

namespace App\Http\Controllers;

use App\Models\Fleets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FleetsController extends Controller
{
    public $booking_before_hour = 6;
    public function GetFleets()
    {
        return Fleets::all();
    }
    public function search(Request $request){
        $distance = $request->input('distance');
        $people = $request->input('passenger')['people'];
        $luggages = $request->input('passenger')['luggages'];

        $fleets = Fleets::where('passengers', '>=' , $people )
            ->where('luggages', '>=' , $luggages)->get();
        if($request->input('bookingType') === 'hourly'){
            foreach ($fleets as $fleet) {
                if($fleet->min_hours >= $distance){
                    $fleet->price = $fleet->min_hours_pay;
                }else{
                    $fleet->price = $fleet->min_hours_pay + (($distance - $fleet->min_hours) * $fleet->after_min_hours);
                }
            }
        }else{
            foreach ($fleets as $fleet) {
                if($fleet->min_distances >= $distance){
                    $fleet->price = $fleet->min_pay;
                }else{
                    $fleet->price = $fleet->min_pay + (($distance - $fleet->min_distances) * $fleet->after_min);
                }

                if($request->input('bookingType') === 'airport'){
                    $fleet->price += $fleet->airport_charge;
                }

                if($request->input('hasReturn')){
                    $fleet->price *= 2;
                }
            }

        }
        return $fleets;
    }

    public function InsertFleets(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passengers' => 'required|integer',
            'luggages' => 'required|integer',
            'min_pay' => 'required|numeric',
            'min_distances' => 'required|numeric',
            'after_min' => 'required|numeric',
            'airport_charge' => 'required|numeric',
            'min_hours' => 'required|numeric',
            'min_hours_pay' => 'required|numeric',
            'after_min_hours' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image upload
        ]);

        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('fleets', 'public'); // Store image in the 'fleets' folder
        }

        // Create a new Fleet record
        $fleet = Fleets::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'passengers' => $validatedData['passengers'],
            'luggages' => $validatedData['luggages'],
            'min_pay' => $validatedData['min_pay'],
            'min_distances' => $validatedData['min_distances'],
            'after_min' => $validatedData['after_min'],
            'airport_charge' => $validatedData['airport_charge'],
            'min_hours' => $validatedData['min_hours'],
            'min_hours_pay' => $validatedData['min_hours_pay'],
            'after_min_hours' => $validatedData['after_min_hours'],
            'image' => $imagePath, // Save image path in the database
        ]);

        // Return response (you can redirect or return success response)
        return response()->json($fleet, 201);
    }

    public function UpdateFleets(Request $request, $id)
    {
        return $request->hasFile('image');
        // Find the fleet
        $fleet = Fleets::findOrFail($id);

        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passengers' => 'required|integer',
            'luggages' => 'required|integer',
            'min_pay' => 'required|numeric',
            'min_distances' => 'required|numeric',
            'after_min' => 'required|numeric',
            'airport_charge' => 'required|numeric',
            'min_hours' => 'required|numeric',
            'min_hours_pay' => 'required|numeric',
            'after_min_hours' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Optionally delete the old image
            if ($fleet->image && Storage::disk('public')->exists($fleet->image)) {
                Storage::disk('public')->delete($fleet->image);
            }

            $image = $request->file('image');
            $validatedData['image'] = $image->store('fleets', 'public');
        }

        // Update the fleet
        $fleet->update($validatedData);

        return response()->json($fleet, 200);
    }


    public function DeleteFleets($id)
    {
        $fleet = Fleets::findOrFail($id);

        // Delete image if exists
        if ($fleet->image && Storage::disk('public')->exists($fleet->image)) {
            Storage::disk('public')->delete($fleet->image);
        }

        // Delete the fleet
        $fleet->delete();

        return response()->json(['message' => 'Fleet deleted successfully.'], 200);
    }

}
