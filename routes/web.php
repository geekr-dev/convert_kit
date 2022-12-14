<?php

use App\Http\Web\Controllers\Mail\BroadcastController;
use App\Http\Web\Controllers\Mail\PreviewBroadcastController;
use App\Http\Web\Controllers\Mail\SendBroadcastController;
use App\Http\Web\Controllers\Subscriber\ImportSubscribersController;
use App\Http\Web\Controllers\Subscriber\SubscriberController;
use Domain\Mail\Jobs\Broadcast\SendBroadcastJob;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('subscribers', SubscriberController::class);
    Route::post('subscribers/import', ImportSubscribersController::class);

    Route::resource('broadcasts', BroadcastController::class);
    Route::post('broadcasts/{broadcast}/send', SendBroadcastController::class);
    Route::get('broadcasts/{broadcast}/preview', PreviewBroadcastController::class)->name('broadcasts.preview');
});



require __DIR__ . '/auth.php';
