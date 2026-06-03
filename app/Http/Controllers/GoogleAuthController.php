<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();
            dd($googleUser);
            $user = User::where('email', $googleUser->getEmail())->first();
            // $user = User::updateOrCreate(
            //     ['email' => $googleUser->getEmail()],
            //     [
            //         'name' => $googleUser->getName(),
            //         'avatar' => $googleUser->getAvatar(),
            //         'google_id' => $googleUser->getId(),
            //         'password' => bcrypt('password'),
            //     ]
            // );
    //dd($user);
          if (!$user) {
    return redirect('/login')->with('error', 'Unauthorized account.');
}else{
    //abort(403,'cannot find user...');
     Auth::login($user);

            request()->session()->regenerate();

            return redirect()->intended('/dashboard');
}
            

           

        } catch (\Exception $e) {

           // dd($e->getMessage());
           abort(403,'cannot find user...');

        }
    }
}