<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Sign Up with Google
     */
    public function signUpWithGoogle()
    {
        session(['google_action' => 'signup']);

        return Socialite::driver('google')->redirect();
    }

    /**
     * Login with Google
     */
    public function loginWithGoogle()
    {
        session(['google_action' => 'login']);

        return Socialite::driver('google')->redirect();
    }

    /**
     * Google Callback
     */
    public function handleGoogleCallback()
    { 
        try {
            $googleUser = Socialite::driver('google')->user();

            $action = session('google_action');
            
            $user = User::where('email', $googleUser->getEmail())->first();

            /**
             * LOGIN FLOW
             */
            if ($action === 'login') {

                if (!$user) {
                    return redirect('/login')
                        ->with('error', 'Account not found. Please sign up first.');
                }

                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                ]);

                Auth::login($user);
                request()->session()->regenerate();

                return redirect()->intended('/dashboard');
            }

            /**
             * SIGNUP FLOW
             */
            if ($action === 'signup') {

                if ($user) {
                    return redirect('/login')
                        ->with('error', 'Email already registered. Please login instead.');
                }

                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),

                    // Required if password column is NOT nullable
                    'password'  => bcrypt('password'),
                ]);

                Auth::login($user);
                request()->session()->regenerate();

                return redirect('/dashboard');
            }

            return redirect('/login')
                ->with('error', 'Invalid Google authentication request.');

        } catch (\Exception $e) {

            return redirect('/login')
                ->with('error', 'Google authentication failed.');
        }
    }
}