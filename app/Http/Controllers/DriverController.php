<?php

namespace App\Http\Controllers;

use App\Models\Drivers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index()
    {
        return Drivers::all();
    }

    public function store(Request $request)
    {
//        return $request->all();
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|unique:drivers,email',
            'phone'            => 'required|string|max:20',
            'address'          => 'required|string|max:255',
            'fleet'            => 'required|string|max:255',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png',
            'driving_license'  => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('drivers/photos', 'public');
            $validated['photo'] = Storage::url($validated['photo']);
        }

        if ($request->hasFile('driving_license')) {
            $validated['driving_license'] = $request->file('driving_license')->store('drivers/licenses', 'public');
            $validated['driving_license'] = Storage::url($validated['driving_license']);
        }

        $driver = Drivers::create($validated);

        return redirect()->back();
}

    public function show($id)
    {
        $driver = Drivers::findOrFail($id);
        return response()->json($driver);
    }

    public function update(Request $request, $id)
    {
        $driver = Drivers::findOrFail($id);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|unique:drivers,email,' . $id,
            'phone'            => 'required|string|max:20',
            'address'          => 'required|string|max:255',
            'fleet'            => 'required|string|max:255',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png',
            'driving_license'  => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($driver->photo) {
                Storage::disk('public')->delete($driver->photo);
            }
            $validated['photo'] = $request->file('photo')->store('drivers/photos', 'public');
            $validated['photo'] = Storage::url($validated['photo']);
        }

        if ($request->hasFile('driving_license')) {
            // Delete old license
            if ($driver->driving_license) {
                Storage::disk('public')->delete($driver->driving_license);
            }
            $validated['driving_license'] = $request->file('driving_license')->store('drivers/licenses', 'public');
            $validated['driving_license'] = Storage::url($validated['driving_license']);
        }

        $driver->update($validated);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $driver = Drivers::findOrFail($id);

        // Delete associated images
        if ($driver->photo) {
            Storage::disk('public')->delete($driver->photo);
        }
        if ($driver->driving_license) {
            Storage::disk('public')->delete($driver->driving_license);
        }

        $driver->delete();

        return redirect()->back();
    }
}
