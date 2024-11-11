<?php
// app/Http/Controllers/ExpenseController.php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Expense;
use App\Models\Profile; // Assurez-vous d'importer le modèle Profile
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExpenseController extends Controller
{
    public function index()
    {
        // Récupérer toutes les dépenses de l'utilisateur connecté
        $expenses = Auth::user()->expenses;
        $profiles = Profile::where('user_id', Auth::id())->get();

        $totals = [];
        $incomeNeeded = [];
        
        foreach ($profiles as $profile) {
            $totals[$profile->id] = $this->calculateTotals($profile->id);
            $incomeNeeded[$profile->id] = $this->calculateIncomeNeeded($profile->id);
        }

        return view('expenses.index', compact('expenses', 'profiles', 'totals', 'incomeNeeded'));
    }

    public function create()
    {
        // Récupérer tous les profils pour les passer à la vue
        $profiles = Profile::where('user_id', Auth::id())->get(); // Récupérer les profils de l'utilisateur connecté
        return view('expenses.create', compact('profiles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|in:subscriptions,housing,food', // Valider que la catégorie est valide
            'amount' => 'required|numeric',
            'profile_id' => 'required|exists:profiles,id', // Valider que le profile_id existe
        ]);

        // Créer une nouvelle dépense associée à l'utilisateur authentifié
        $expense = new Expense([
            'category' => $request->category,
            'amount' => $request->amount,
            'user_id' => Auth::id(), // Utiliser Auth pour obtenir l'ID de l'utilisateur connecté
            'profile_id' => $request->profile_id, // Associer la dépense au profil sélectionné
        ]);

        $expense->save();

        return redirect()->route('expenses.index')->with('success', 'Dépense créée avec succès.');
    }

    public function show(Expense $expense)
    {
        // Vérifier si la dépense appartient à l'utilisateur authentifié
        if ($expense->user_id !== Auth::id()) {
            return abort(403, 'Accès refusé.');
        }

        return view('expenses.show', compact('expense'));
    }

    public function destroy(Expense $expense)
    {
        // Vérifier si la dépense appartient à l'utilisateur authentifié avant de la supprimer
        if ($expense->user_id !== Auth::id()) {
            return abort(403, 'Accès refusé.');
        }

        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Dépense supprimée avec succès.');
    }
    protected function calculateTotals($profileId)
    {
        // Récupérer les dépenses pour le profil spécifique
        $expenses = Expense::where('profile_id', $profileId)->get();

        // Initialiser les totaux
        $totals = [
            'subscriptions' => 0,
            'housing' => 0,
            'food' => 0,
            'monthly' => 0,
            'yearly' => 0,
            'biweekly' => 0,
            'hourly' => 0,
        ];

        // Calculer les totaux par catégorie
        foreach ($expenses as $expense) {
            $totals[$expense->category] += $expense->amount;
        }

        // Calculer les totaux mensuel, annuel, bimensuel et horaire
        $totals['monthly'] = array_sum($totals);
        $totals['yearly'] = $totals['monthly'] * 12;
        $totals['biweekly'] = $totals['monthly'] / 2;
        $totals['hourly'] = $totals['monthly'] / (40 * 4); // Supposons 40 heures par semaine

        return $totals;
    }

    protected function calculateIncomeNeeded($profileId)
    {
        $totals = $this->calculateTotals($profileId);
        
        // Supposons que l'utilisateur travaille 40 heures par semaine
        $hourlyIncomeNeeded = $totals['monthly'] / (40 * 4); // 40 heures par semaine * 4 semaines
        
        return [
            'monthly' => $totals['monthly'],
            'hourly' => $hourlyIncomeNeeded,
        ];
    }
    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense')); // Afficher le formulaire d'édition
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $expense->update($request->all()); // Mettre à jour la dépense
        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function remove(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
   public function generatePDF($profileId)
{
    // Try to fetch the profile and expenses
    try {
        $profile = Profile::findOrFail($profileId);
        $expenses = Expense::where('profile_id', $profileId)->get();

        // Check if expenses exist
        if ($expenses->isEmpty()) {
            return back()->with('error', 'No expenses found for this profile.');
        }

        // Generate the PDF
        $pdf = PDF::loadView('expenses.pdf', [
            'profile' => $profile,
            'expenses' => $expenses,
        ])->setPaper('a4', 'portrait'); // Optional: Set paper size and orientation

        // Download the PDF
        return $pdf->download('expenses_' . strtolower(str_replace(' ', '_', $profile->name)) . '.pdf');
    } catch (\Exception $e) {
        // Log the error or handle it appropriately
        return back()->with('error', 'Could not generate PDF: ' . $e->getMessage());
    }
}
public function printSummary($profileId)
{
    // Récupérez le profil par ID
    $profile = Profile::findOrFail($profileId);
    
    // Récupérez les totaux et les revenus nécessaires
    $totals = $this->calculateTotals($profileId);
    $incomeNeeded = $this->calculateIncomeNeeded($profileId);
    
    // Générer le PDF pour un seul profil
    $pdf = PDF::loadView('expenses.summary_pdf', compact('profile', 'totals', 'incomeNeeded'));
    
    // Retourner le PDF au navigateur
    return $pdf->download('profile_' . $profile->id . '_summary.pdf');
}
}
