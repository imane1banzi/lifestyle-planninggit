<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
  // Vérifier si l'utilisateur est connecté
  if (Auth::check()) {
    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Compte le nombre total de profils associés à l'utilisateur
    $totalProfiles = Profile::where('user_id', $user->id)->count();

    // Somme des montants des dépenses de l'utilisateur connecté
    $totalExpenses = Expense::where('user_id', $user->id)->sum('amount');

    // Calculer le total des dépenses de l'année écoulée et multiplier par 12 pour obtenir une estimation annuelle
    $yearlyTotal = Expense::where('user_id', $user->id)
                           ->where('created_at', '>=', now()->subYear())
                           ->sum('amount') * 12;

    // Retourner les résultats à la vue pour un utilisateur connecté
    return view('dashboard', compact('totalProfiles', 'totalExpenses', 'yearlyTotal'));
} else {
    // Si l'utilisateur n'est pas connecté, retourner la vue pour les invités
    return view('guest.dashboard'); // Assurez-vous que cette vue existe
}
}
}
