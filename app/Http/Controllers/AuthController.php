<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        $user_exists = User::where('username', $credentials['username'])->get();

        if ($user_exists->isEmpty()) {
            $user = new User;
            $user->username = $credentials['username'];
            $user->password = $credentials['password'];
            $user->save();
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended();
            } else {
                // Supposedly unreachable
                error_log('What the f*ck bro!!! (login edition)');

                return Response(['status' => 500]);
            }
        } else {
            return 'Incorrect password.';
        }

        return 'The end is near.';
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        // Invalidate the user's session to prevent reuse
        $request->session()->invalidate();

        // Regenerate the session token for security
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}
