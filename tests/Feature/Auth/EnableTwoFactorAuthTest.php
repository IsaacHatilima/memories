<?php

use App\Models\User;
use PragmaRX\Google2FA\Google2FA;

test('user can enable two factor auth', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/user/two-factor-authentication');
    $response->assertStatus(302);

    $this->assertNotNull($user->fresh()->two_factor_secret);
    $this->assertNotNull($user->fresh()->two_factor_recovery_codes);
});

test('user can confirm two factor auth', function () {
    $user = User::factory()->create();
    $user->forceFill([
        'two_factor_secret' => encrypt('base32secret3232'),
        'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1', 'recovery-code-2'])),
    ])->save();

    $validCode = app(Google2FA::class)->getCurrentOtp(decrypt($user->two_factor_secret));

    $response = $this->actingAs($user)->post('/user/confirmed-two-factor-authentication', [
        'code' => $validCode,
    ]);
    $response->assertSessionHas('status', 'two-factor-authentication-confirmed');
});

test('user can get two factor auth recovery codes', function () {
    $user = User::factory()->create();
    $user->forceFill([
        'two_factor_secret' => encrypt('base32secret3232'),
        'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1', 'recovery-code-2'])),
    ])->save();

    $validCode = app(Google2FA::class)->getCurrentOtp(decrypt($user->two_factor_secret));

    $this->actingAs($user)->post('/user/confirmed-two-factor-authentication', [
        'code' => $validCode,
    ]);

    $response = $this->actingAs($user)->post('/user/two-factor-recovery-codes');
    $response->assertSessionHas('status', 'recovery-codes-generated');
});

test('user can get two factor auth qr code', function () {
    $user = User::factory()->create();
    $user->forceFill([
        'two_factor_secret' => encrypt('base32secret3232'),
        'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1', 'recovery-code-2'])),
    ])->save();

    $validCode = app(Google2FA::class)->getCurrentOtp(decrypt($user->two_factor_secret));

    $this->actingAs($user)->post('/user/confirmed-two-factor-authentication', [
        'code' => $validCode,
    ]);

    $response = $this->actingAs($user)->post('/user/two-factor-qr-code');
    $response->assertSessionHas('status', 'two-factor-authentication-confirmed');
});

test('user can disable or cancel two factor auth', function () {
    $user = User::factory()->create();
    $user->forceFill([
        'two_factor_secret' => encrypt('base32secret3232'),
        'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1', 'recovery-code-2'])),
    ])->save();


    $response = $this->actingAs($user)->delete('/user/two-factor-authentication');
    $response->assertStatus(302);


    $this->assertNull($user->fresh()->two_factor_secret);
    $this->assertNull($user->fresh()->two_factor_recovery_codes);
});

test('user can delete two factor auth confirmed at date', function () {
    $user = User::factory()->create();
    $user->forceFill([
        'two_factor_secret' => encrypt('base32secret3232'),
        'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1', 'recovery-code-2'])),
    ])->save();

    $validCode = app(Google2FA::class)->getCurrentOtp(decrypt($user->two_factor_secret));

    $this->actingAs($user)->post('/user/confirmed-two-factor-authentication', [
        'code' => $validCode,
    ]);


    $response = $this->actingAs($user)->patch(route('clear.2fa.confirmation'));
    $response->assertStatus(200);
});

test('user can toggle codes downloaded', function () {
    $user = User::factory()->create();
    $user->forceFill([
        'two_factor_secret' => encrypt('base32secret3232'),
        'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1', 'recovery-code-2'])),
    ])->save();

    $validCode = app(Google2FA::class)->getCurrentOtp(decrypt($user->two_factor_secret));

    $this->actingAs($user)->post('/user/confirmed-two-factor-authentication', [
        'code' => $validCode,
    ]);


    $response = $this->actingAs($user)->patch(route('recovery.codes'));
    $response->assertStatus(200);
});
