<?php

use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
  'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
  Route::inertia('dashboard', 'Dashboard')->name('dashboard');

  Route::post("/wishlist", [WishlistController::class, 'store'])->name('store');
});

Route::get('/api/test', function () {
  return response()->json(['message' => 'Laravel and Nuxt are connected!']);
});



require __DIR__ . '/settings.php';