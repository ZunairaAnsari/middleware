<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //

    public function store(Request $request){

        $validate = $request->validate([
            'name' =>'required|string|max:255',
            'email' =>'required|email|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'role' => 'required|string'
        ]);

        $validate['password'] = bcrypt($validate['password']); 

        $validate['remember_token'] = Str::random(60);

        User::create($validate);

        return redirect()->route('login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials,$request->has('remember_token'))) {
            $user = Auth::user();
            return redirect()->route('dashboard');
        } 
        else {

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput();
        }
    }

public function dashboardPage() {
    return view('dashboard');
}

public function logout(){
    Auth::logout();
    return redirect()->route('login');
}

}
