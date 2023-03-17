<?php

use App\Http\Controllers\ExamplesController;
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
    return to_route('examples.main');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(ExamplesController::class)
        ->group(function() {
            Route::get("/examples/main", 'mainInterface')
                ->name("examples.main");

            Route::get("/examples/image", 'exampleImage')
                ->name("examples.image");

            Route::post("/examples/image", 'exampleImageRequest')
                ->name('examples.image.request');

            Route::get("/examples/barber", 'exampleBarberShop')
                ->name("examples.barber");

            Route::post("/examples/barber", 'exampleBarberShopRequest')
                ->name('examples.barber.request');

            Route::get("/examples/planning", 'examplePlanning')
                ->name("examples.planning");

            Route::post("/examples/ask", 'ask')
                ->name('examples.ask');
        });



});
