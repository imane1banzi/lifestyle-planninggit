<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuickStartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LifestyleController;
use App\Http\Controllers\CategoryItemController;
use App\Http\Controllers\RecommendationController;
// Redirection de la page d'accueil vers le tableau de bord directement
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Tableau de bord - accessible sans authentification
Route::get('/dashboard', [DashboardController::class, 'index'])
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
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

    // Route pour générer le PDF d'un profil
    Route::get('expenses/pdf/{profile}', [ExpenseController::class, 'printSummary'])->name('expenses.pdf');
    Route::resource('categories', CategoryController::class)->except(['show']);
Route::post('/calculate-hourly-rate', [LifestyleController::class, 'calculateHourlyRate'])->name('calculate.hourly.rate');
Route::resource('category-items', CategoryItemController::class);
Route::post('/categories/{category}/items', [CategoryItemController::class, 'store'])->name('categories.items.store');
Route::get('categories/manage', [CategoryController::class, 'manage'])->name('categories.manage');
Route::resource('recommendations', RecommendationController::class);

});
// In your routes file, e.g., web.php

// Quick Start Routes
 // Page principale
Route::get('/quick-start', [QuickStartController::class, 'index'])->name('quick.index');
Route::post('/quick-start/profile', [QuickStartController::class, 'createProfile'])->name('quick.createProfile'); // Création d'un profil
Route::post('/quick-start/expense', [QuickStartController::class, 'createExpense'])->name('quick.createExpense'); // Ajout d'une dépense
Route::get('/quick-start/summary', [QuickStartController::class, 'summary'])->name('quick.summary'); // Résumé des profils et dépenses

// Routes pour les catégories et leurs items
Route::post('/quick-start/cat', [QuickStartController::class, 'addCategory'])->name('categories.store'); // Création d'une catégorie
Route::post('/quick-start/cat-item', [QuickStartController::class, 'addCategoryItem'])->name('quick.category-items.store');
 // Ajout d'un item à une catégorie



// Chargement des routes d'authentification
require __DIR__.'/auth.php';
