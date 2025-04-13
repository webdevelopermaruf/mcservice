<?php

namespace App\Http\Controllers;

use App\Models\Fleets;
use App\Models\Passengers;
use App\Models\Trips;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.Home');
    }

    public function login()
    {
        return view('admin.Login');
    }
    public function logout(Request $request)
    {
        $request->session()->invalidate(); // Invalidate the current session
        $request->session()->regenerateToken(); // Regenerate the CSRF token
        return redirect('/admin/login');
    }
    public function AttemptLogin(Request $request)
    {
        $attempt = Auth::attempt($request->only('email', 'password'));
        if ($attempt) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }else{
            return redirect()->back()->with('error', 'Invalid emails or password');
        }
    }

    public function forgetPassword()
    {
        return Inertia::render('admin/ForgetPassword');
    }

    public function changePassword(Request $request)
    {
        $user = User::where('emails', $request->email)->first();
        if($request->new_password === $request->confirm_password){
            $user->update([
                'password'=> bcrypt($request->new_password)
            ]);
            return redirect()->to('/admin/login')->with('success', 'Password Changed Successfully');
        }else{
            return redirect()->back()->with('error', 'New password and confirm password does not match');
        }
    }

    public function fleets()
    {
        return Inertia::render('admin/Fleets');
    }

    public function drivers()
    {
        return Inertia::render('admin/Drivers');
    }
    public function passengers()
    {
        $passengers = Passengers::all();
        return Inertia::render('admin/Passengers',['passengers' => $passengers]);
    }

    public function trips()
    {
        $trips= Trips::all();
        return Inertia::render('admin/Trips',['trips'=>$trips]);
    }

    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
