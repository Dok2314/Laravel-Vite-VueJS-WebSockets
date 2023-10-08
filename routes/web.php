<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers as C;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/messages', [C\MessageController::class, 'index']);
    Route::post('/messages', [C\MessageController::class, 'store']);

    Route::get('/users/{user}', [C\UserController::class, 'show']);
    Route::post('/users/{user}', [C\UserController::class, 'sendLike']);

    Route::get('/profile', [C\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [C\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [C\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
