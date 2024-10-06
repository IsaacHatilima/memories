<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\SetPasswordOnGoogleSignUp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $rules = $request->user()->social_auth_sign_up
            ? app(SetPasswordOnGoogleSignUp::class)->rules()
            : app(PasswordUpdateRequest::class)->rules();

        $validatedData = $request->validate($rules);

        $updateData = ['password' => Hash::make($validatedData['password'])];

        if ($request->user()->social_auth_sign_up) {
            $updateData['social_auth_sign_up'] = false;
        }

        $request->user()->update($updateData);

        return back();
    }
}
