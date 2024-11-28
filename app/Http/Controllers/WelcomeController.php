<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            return redirect()->route('dashboard');
        }

        return view('welcome');
    }
}
