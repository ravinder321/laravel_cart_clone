<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        // Redirect the user to Google's OAuth 2.0 server
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        try {
            // Get user information from Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if the user already exists
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(12)),  // Generate a random password for the user
                ]
            );

            // Log in the user
            Auth::login($user);

            // Redirect to the intended page (or homepage)
            return redirect()->intended('/')->with('success', 'Google login successful!');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }
}
