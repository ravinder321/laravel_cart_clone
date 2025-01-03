<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // Your User model
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class FacebookAuthController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            // Retrieve user info from Facebook via Socialite
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            // Check if user already exists in the database
            $user = User::where('email', $facebookUser->getEmail())->first();

            // If not, create a new user
            if (!$user) {
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'password' => bcrypt(Str::random(10)), // Generate a secure random password
                ]);
            }

            // Log in the user
            Auth::login($user);

            // Return a JSON response with success details
            return redirect()->intended('/')->with('success', 'facebook login successful!');

        } catch (Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());

            // Return an error response if something goes wrong
            return response()->json([
                'success' => false,
                'message' => 'Failed to login with Facebook.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
