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

  // Vérifiez si l'utilisateur est authentifié
  if ($user) {
      // Si l'utilisateur est connecté, récupérer les données
      $totalProfiles = Profile::where('user_id', $user->id)->count();
      $totalExpenses = Expense::where('user_id', $user->id)->sum('amount');
      $yearlyTotal = Expense::where('user_id', $user->id)
                          ->where('created_at', '>=', now()->subYear())
                          ->sum('amount') * 12;

      // Retourner les résultats à la vue
      return view('dashboard', compact('totalProfiles', 'totalExpenses', 'yearlyTotal'));
  } else {
      // Si l'utilisateur n'est pas connecté, ne renvoyer aucune donnée supplémentaire
      return view('dashboard');
  }
}
}
