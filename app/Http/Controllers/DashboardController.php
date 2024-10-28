<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProfiles = Profile::count(); // Compte le nombre total de profils
        $totalExpenses = Expense::sum('amount'); // Somme des montants des dépenses
        $yearlyTotal = Expense::where('created_at', '>=', now()->subYear())->sum('amount')*12;

        return view('dashboard', compact('totalProfiles', 'totalExpenses', 'yearlyTotal'));
    }
}
