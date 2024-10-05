<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class TwoFactorAuthCodeController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/TwoFactorAuthCode');
    }
}
