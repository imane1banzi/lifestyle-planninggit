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

     // Retourner les résultats à la vue
     return view('dashboard', compact('totalProfiles', 'totalExpenses', 'yearlyTotal'));
 }
}
