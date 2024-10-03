<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    private User $user;
    function __construct()
    {
        $this->user = Auth::user();
    }
    public function updateProfile($request):void
    {
        if ($this->user->email !== $request->email) {
            $this->user->fill([
                'email_verified_at' => null,
            ]);
        }

        $this->user->fill([
            'email' => $request->email,
        ]);

        $this->user->profile->fill([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
        ]);

        $this->user->save();
        $this->user->profile->save();
    }

    public function copyRecoveryCodes($request):void
    {
        $request->user()->downloaded_code = !$request->user()->downloaded_code;
        $request->user()->save();
    }

    public function cancelTwoFactorAuthentication($request):void
    {
        $request->user()->two_factor_confirmed_at = null;
        $request->user()->save();
    }

    public function deleteAccount($request):void
    {
        Auth::logout();

        $this->user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
