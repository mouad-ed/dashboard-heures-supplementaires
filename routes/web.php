
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\HeureController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTH + PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ADMIN REGISTER
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/register', function () {

        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('auth.register');

    })->name('admin.register');

    /*
    |--------------------------------------------------------------------------
    | ELEVES
    |--------------------------------------------------------------------------
    */

    Route::resource('eleves', EleveController::class);

    /*
    |--------------------------------------------------------------------------
    | ENSEIGNANTS
    |--------------------------------------------------------------------------
    */

    Route::resource('enseignants', EnseignantController::class);

    /*
    |--------------------------------------------------------------------------
    | SEANCES
    |--------------------------------------------------------------------------
    */

    Route::resource('seances', SeanceController::class);

    /*
    |--------------------------------------------------------------------------
    | HEURES
    |--------------------------------------------------------------------------
    */

    Route::resource('heures', HeureController::class);

    /*
    |--------------------------------------------------------------------------
    | SALAIRES
    |--------------------------------------------------------------------------
    */

    Route::get('/salaires', [EnseignantController::class, 'salaires'])
        ->name('salaires.index');

});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

