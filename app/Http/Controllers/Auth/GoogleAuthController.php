<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        /** @var GoogleProvider $driver */
        $driver = Socialite::driver('google');
        $googleUser = $driver->stateless()->user();

        if (! isset($googleUser->user['given_name']) || ! isset($googleUser->user['family_name'])) {
            return redirect()->route('login')->with(['email' => 'Your Google account is missing names.']);
        }

        $user = User::where('email', $googleUser->user['email'])->first();

        if (! $user) {
            $user = User::create([
                'email' => $googleUser->email,
                'password' => Str::random(),
                'email_verified_at' => now(),
                'social_auth_sign_up' => true,
            ]);

            $user->profile()->updateOrCreate([
                'user_id' => $user->id,
                'first_name' => $googleUser->user['given_name'],
                'last_name' => $googleUser->user['family_name']
            ]);
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

