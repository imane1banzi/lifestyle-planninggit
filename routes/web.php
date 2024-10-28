<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login'); // redirige vers la page de connexion
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
      // Route pour afficher le formulaire de création de profil
      Route::get('/profiles/create', [ProfileController::class, 'create'])->name('profiles.create');

      // Route pour enregistrer un nouveau profil
      Route::post('/profiles', [ProfileController::class, 'store'])->name('profiles.store');
  
      // Route pour afficher un profil particulier (par ID)
      Route::get('/profiles/{profile}', [ProfileController::class, 'show'])->name('profiles.show');
});
// Routes pour les Profils
Route::middleware(['auth'])->group(function () {
    Route::resource('profiles', UserProfileController::class);
    Route::resource('expenses', ExpenseController::class);
});
Route::delete('/expenses/{expense}', [ExpenseController::class, 'remove'])->name('expenses.remove');

require __DIR__.'/auth.php';
