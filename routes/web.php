<?php

declare(strict_types=1);

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Reset;
use App\Livewire\Dashboard\Home as Dashboard;
use App\Livewire\Frontend\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class);

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
Route::get('/reset', Reset::class)->name('reset');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard.home');
});
