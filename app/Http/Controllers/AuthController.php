<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function showLogin () {
        return view('login');
    }

    public function login (Request $request) {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended();
        }

        $user_exists = User::find(['username' => $credentials['username']]);

        if ($user_exists->empty()) {
            $user = new User;
            $user->username=$credentials['username'];
            $user->password=$credentials['password'];
            $user->save();
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended();
            }
            else {
                // Supposedly unreachable
                error_log('What the fuck bro!!! (login edition)');
                return Response(['status' => 500]);
            }
        }
        else {
            return 'Incorrect password.';
        }
        return 'The end is near.';
    }
}
