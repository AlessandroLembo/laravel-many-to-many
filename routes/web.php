<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\Guest\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProjectController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [GuestHomeController::class, 'index']);

// # Rotte che vedo solo se sono loggato
Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function () {
    // Home dell'utente loggato
    Route::get('/', [AdminHomeController::class, 'index'])->name('home');

    // Rotte dei project incorporate con resource()
    Route::resource('projects', ProjectController::class);

    // Rotte dei project costruite singolarmente:

    // Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    // Route::get('/projects{project}', [ProjectController::class, 'show'])->name('projects.show');
    // Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    // Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    // Route::get('/projects{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    // Route::put('/projects{project}', [ProjectController::class, 'update'])->name('projects.update');
    // Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Rotta del Toggle
    Route::patch('/projects/{project}/toggle', [ProjectController::class, 'toggle'])->name('projects.toggle');
});

Route::middleware('auth')->prefix('/profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__ . '/auth.php';
