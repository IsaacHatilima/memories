<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        /**
         * To override Fortify authentication
         */
//        Fortify::authenticateUsing(function (Request $request) {
//
//            $request->validate([
//                Fortify::username() => 'required|string',
//                'password' => 'required|string',
//            ]);
//
//            // Retrieve the user by the username (email or username)
//            $user = User::where(Fortify::username(), $request->input(Fortify::username()))->first();
//
//            // Check if user is valid
//            if (!$user) {
//                throw ValidationException::withMessages([
//                    'msg' => 'Invalid E-mail or Password provided',
//                ]);
//            }
//
//            // Make more check like is account is active etc
//
//            // Check the password
//            if (Hash::check($request->input('password'), $user->password)) {
//                // Make changes like last_login if it is part of the User model
//                $user->last_login = now();
//                $user->save();
//
//                return $user;
//            } else {
//                // Some action is invalid password
//                throw ValidationException::withMessages([
//                    'msg' => 'Invalid E-mail or Password provided',
//                ]);
//            }
//        });
    }
}
