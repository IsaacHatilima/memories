<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmPasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ProfileService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile($request);
        return Redirect::route('profile.edit');
    }

    /**
     * Toggle Recover Codes copied
     */
    public function copy_recovery_codes(Request $request)
    {
        $this->profileService->copyRecoveryCodes($request);
        return response(null, 200);
    }

    /**
     * Cancel Two-Factor Authentication setup process
     */
    public function clear_two_factor_confirmed_at(Request $request)
    {
        $this->profileService->cancelTwoFactorAuthentication($request);
        return response(null, 200);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(ConfirmPasswordRequest $request): RedirectResponse
    {
        $this->profileService->deleteAccount($request);

        return Redirect::to('/');
    }
}
