<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login'); // redirige vers la page de connexion
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

require __DIR__.'/auth.php';
