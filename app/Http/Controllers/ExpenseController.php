<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpenseController extends Controller
{
    /**
     * Liste des dépenses de l'utilisateur connecté.
     */
    public function index()
{
    // Récupérer l'utilisateur authentifié
    $user = Auth::user();

    // Récupérer toutes les dépenses de l'utilisateur avec la catégorie associée
    $expenses = Expense::where('user_id', $user->id)
                        ->with('category')  // Inclure la relation category
                        ->get(); // Récupérer les dépenses avec leurs catégories

    // Récupérer les profils de l'utilisateur
    $profiles = Profile::where('user_id', $user->id)->get();

    // Calculer les totaux pour chaque profil
    $totals = [];
    $incomeNeeded = [];

    foreach ($profiles as $profile) {
        $totals[$profile->id] = $this->calculateTotals($profile->id);
        $incomeNeeded[$profile->id] = $this->calculateIncomeNeeded($profile->id);
    }

    return view('expenses.index', compact('expenses', 'profiles', 'totals', 'incomeNeeded'));
}

    /**
     * Affiche le formulaire pour créer une dépense.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get(); // Charger les catégories actives
        $profiles = Profile::where('user_id', Auth::id())->get(); // Profils de l'utilisateur connecté

        return view('expenses.create', compact('categories', 'profiles'));
    }

    /**
     * Enregistre une nouvelle dépense.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id', // Valide que la catégorie existe
            'profile_id' => 'required|exists:profiles,id', // Valide que le profil existe
        ]);

        // Récupérer le total de la catégorie sélectionnée
        $category = Category::findOrFail($request->category_id);

        Expense::create([
            'category_id' => $request->category_id,
            'amount' => $category->total_cost, // Utiliser le total de la catégorie
            'user_id' => Auth::id(),
            'profile_id' => $request->profile_id,
        ]);
        dd($request->all());
        return redirect()->route('expenses.index')->with('success', 'Expense created successfully!');
    }

    /**
     * Affiche une dépense spécifique.
     */
    public function show(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('expenses.show', compact('expense'));
    }

    /**
     * Affiche le formulaire pour éditer une dépense.
     */
    public function edit(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::where('is_active', true)->get(); // Charger les catégories actives
        $profiles = Profile::where('user_id', Auth::id())->get(); // Profils de l'utilisateur connecté

        return view('expenses.edit', compact('expense', 'categories', 'profiles'));
    }

    /**
     * Met à jour une dépense existante.
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'profile_id' => 'required|exists:profiles,id',
        ]);

        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Récupérer le total de la catégorie sélectionnée
        $category = Category::findOrFail($request->category_id);

        $expense->update([
            'category_id' => $request->category_id,
            'amount' => $category->total_cost, // Mettre à jour avec le total de la catégorie
            'profile_id' => $request->profile_id,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
    }

    /**
     * Supprime une dépense.
     */
    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
    }

    /**
     * Calcule les totaux des dépenses pour un profil.
     */
    protected function calculateTotals($profileId)
{
    $expenses = Expense::where('profile_id', $profileId)->with('category')->get();

    $totals = [
        'categories' => [],
        'monthly' => 0,
        'yearly' => 0,
        'biweekly' => 0,
        'hourly' => 0,
    ];

    foreach ($expenses as $expense) {
        $categoryName = $expense->category->name ?? 'Other';  // Handle category
        $totals['categories'][$categoryName] = ($totals['categories'][$categoryName] ?? 0) + $expense->amount;
    }

    $totals['monthly'] = array_sum($totals['categories']);
    $totals['yearly'] = $totals['monthly'] * 12;
    $totals['biweekly'] = $totals['monthly'] / 2;
    $totals['hourly'] = $totals['monthly'] / (40 * 4);  // Assuming 40 hours/week

    return $totals;
}


    /**
     * Calcule le revenu nécessaire pour un profil.
     */
    protected function calculateIncomeNeeded($profileId)
    {
        $totals = $this->calculateTotals($profileId);

        $hourlyIncomeNeeded = $totals['monthly'] / (40 * 4); // 40 heures par semaine

        return [
            'monthly' => $totals['monthly'],
            'hourly' => $hourlyIncomeNeeded,
        ];
    }

    /**
     * Génère un PDF pour un profil spécifique.
     */
    public function generatePDF($profileId)
    {
        $profile = Profile::findOrFail($profileId);
        $expenses = Expense::where('profile_id', $profileId)->get();

        if ($expenses->isEmpty()) {
            return back()->with('error', 'No expenses found for this profile.');
        }

        $pdf = Pdf::loadView('expenses.pdf', compact('profile', 'expenses'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('expenses_' . strtolower(str_replace(' ', '_', $profile->name)) . '.pdf');
    }

    /**
     * Imprime un résumé des dépenses d'un profil en PDF.
     */
    public function printSummary($profileId)
{
    $profile = Profile::findOrFail($profileId);

    // Fetch expenses for the profile and their associated categories
    $expenses = Expense::where('profile_id', $profileId)->with('category')->get();

    // Calculate totals (by category)
    $totals = $this->calculateTotals($profileId);

    // Calculate income needed
    $incomeNeeded = $this->calculateIncomeNeeded($profileId);

    // Get only the categories associated with the expenses for this profile
    $categories = $expenses->pluck('category')->unique();

    // Load the PDF view
    $pdf = Pdf::loadView('expenses.summary_pdf', compact('profile', 'totals', 'incomeNeeded', 'categories'));

    return $pdf->download('profile_' . $profile->id . '_summary.pdf');
}

}
