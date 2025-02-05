<?php

declare(strict_types=1);

use App\Livewire\Auth\Register;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    Event::fake([Registered::class]);
});

test('registration page is accessible', function () {
    $this->get('/register')
        ->assertStatus(200);
});

test('can render register component', function () {
    Livewire::test(Register::class)
        ->assertStatus(200);
});

test('requires all fields for registration', function () {
    Livewire::test(Register::class)
        ->set('name', '')
        ->set('email', '')
        ->set('password', '')
        ->set('password_confirmation', '')
        ->call('register')
        ->assertHasErrors([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
});

test('requires valid email', function () {
    Livewire::test(Register::class)
        ->set('email', 'invalid-email')
        ->call('register')
        ->assertHasErrors(['email' => 'email']);
});

test('requires minimum password length', function () {
    Livewire::test(Register::class)
        ->set('password', '123')
        ->set('password_confirmation', '123')
        ->call('register')
        ->assertHasErrors(['password' => 'min']);
});

test('requires password confirmation', function () {
    Livewire::test(Register::class)
        ->set('password', 'password123')
        ->set('password_confirmation', 'different-password')
        ->call('register')
        ->assertHasErrors(['password' => 'confirmed']);
});

test('email must be unique', function () {
    $existingUser = User::factory()->create();

    Livewire::test(Register::class)
        ->set('email', $existingUser->email)
        ->call('register')
        ->assertHasErrors(['email' => 'unique']);
});

test('can register new user', function () {
    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasNoErrors();

    $user = User::whereEmail('test@example.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->name)->toBe('Test User')
        ->and(Hash::check('password123', $user->password))->toBeTrue();

    Event::assertDispatched(Registered::class);
});

test('user is redirected after registration', function () {
    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertRedirect('/dashboard'); // Adjust this path according to your routes
});

test('verification email is sent after registration', function () {
    Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register');

    Event::assertDispatched(Registered::class, function ($event) {
        return $event->user->email === 'test@example.com';
    });
});
