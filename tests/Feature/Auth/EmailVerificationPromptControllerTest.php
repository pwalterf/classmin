<?php

namespace Tests\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

beforeEach(function () {
    Route::get('/email/verify', \App\Http\Controllers\Auth\EmailVerificationPromptController::class)
        ->name('verification.notice');
    Route::get('/dashboard', fn () => 'Dashboard')->name('dashboard');
});

test('it redirects to the dashboard if the email is verified', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);

    actingAs($user);

    $response = get(route('verification.notice'));

    $response->assertRedirect(route('dashboard'));
});

test('it shows the email verification page if the email is not verified', function () {
    $user = User::factory()->create(['email_verified_at' => null]);

    actingAs($user);

    $response = get(route('verification.notice'));

    $response->assertOk();
    $response->assertSee('VerifyEmail');
});
