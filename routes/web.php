<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Redirection de la page d'accueil vers la page de connexion
Route::get('/', function () {
    return redirect()->route('login');
});

// Tableau de bord - accessible uniquement aux utilisateurs authentifiés et vérifiés
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Routes protégées par le middleware 'auth'
Route::middleware('auth')->group(function () {

    // Routes pour la gestion des profils utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour la gestion de UserProfileController avec Resource
    Route::resource('profiles', UserProfileController::class);

    // Routes pour la gestion des dépenses (expenses)
    Route::resource('expenses', ExpenseController::class);

    // Route pour supprimer une dépense spécifique
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'remove'])->name('expenses.remove');

    // Route pour générer le PDF d'un profil
    Route::get('expenses/pdf/{profile}', [ExpenseController::class, 'printSummary'])->name('expenses.pdf');
});

// Chargement des routes d'authentification
require __DIR__.'/auth.php';
