<?php

declare(strict_types=1);

use App\Livewire\Frontend\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class);
