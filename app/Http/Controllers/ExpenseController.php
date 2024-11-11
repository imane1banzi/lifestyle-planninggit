<?php
// app/Http/Controllers/ExpenseController.php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Expense;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        // Retrieve expenses and profiles based on authentication
        $expenses = Auth::check() ? Auth::user()->expenses : Expense::all();
        $profiles = Auth::check() ? Profile::where('user_id', Auth::id())->get() : Profile::all();

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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour créer une dépense.');
        }

        $profiles = Profile::where('user_id', Auth::id())->get();
        return view('expenses.create', compact('profiles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|in:subscriptions,housing,food',
            'amount' => 'required|numeric',
            'profile_id' => 'required|exists:profiles,id',
        ]);

        if (Auth::check()) {
            $expense = new Expense([
                'category' => $request->category,
                'amount' => $request->amount,
                'user_id' => Auth::id(),
                'profile_id' => $request->profile_id,
            ]);

            $expense->save();

            return redirect()->route('expenses.index')->with('success', 'Dépense créée avec succès.');
        }

        return redirect()->route('login')->with('error', 'Vous devez être connecté pour créer une dépense.');
    }

    public function show(Expense $expense)
    {
        if (Auth::check() && $expense->user_id === Auth::id()) {
            return view('expenses.show', compact('expense'));
        }

        return abort(403, 'Accès refusé.');
    }

    public function destroy(Expense $expense)
    {
        if (!Auth::check() || $expense->user_id !== Auth::id()) {
            return abort(403, 'Accès refusé.');
        }

        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Dépense supprimée avec succès.');
    }

    protected function calculateTotals($profileId)
    {
        $expenses = Expense::where('profile_id', $profileId)->get();

        $totals = [
            'subscriptions' => 0,
            'housing' => 0,
            'food' => 0,
            'monthly' => 0,
            'yearly' => 0,
            'biweekly' => 0,
            'hourly' => 0,
        ];

        foreach ($expenses as $expense) {
            $totals[$expense->category] += $expense->amount;
        }

        $totals['monthly'] = array_sum($totals);
        $totals['yearly'] = $totals['monthly'] * 12;
        $totals['biweekly'] = $totals['monthly'] / 2;
        $totals['hourly'] = $totals['monthly'] / (40 * 4);

        return $totals;
    }

    protected function calculateIncomeNeeded($profileId)
    {
        $totals = $this->calculateTotals($profileId);
        $hourlyIncomeNeeded = $totals['monthly'] / (40 * 4);

        return [
            'monthly' => $totals['monthly'],
            'hourly' => $hourlyIncomeNeeded,
        ];
    }

    public function edit(Expense $expense)
    {
        if (!Auth::check() || $expense->user_id !== Auth::id()) {
            return abort(403, 'Accès refusé.');
        }
        
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        if (!Auth::check() || $expense->user_id !== Auth::id()) {
            return abort(403, 'Accès refusé.');
        }

        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $expense->update($request->all());
        return redirect()->route('expenses.index')->with('success', 'Dépense mise à jour avec succès.');
    }

    public function remove(Expense $expense)
    {
        if (!Auth::check() || $expense->user_id !== Auth::id()) {
            return abort(403, 'Accès refusé.');
        }

        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Dépense supprimée avec succès.');
    }

    public function generatePDF($profileId)
    {
        try {
            $profile = Profile::findOrFail($profileId);
            $expenses = Expense::where('profile_id', $profileId)->get();

            if ($expenses->isEmpty()) {
                return back()->with('error', 'Aucune dépense trouvée pour ce profil.');
            }

            $pdf = Pdf::loadView('expenses.pdf', [
                'profile' => $profile,
                'expenses' => $expenses,
            ])->setPaper('a4', 'portrait');

            return $pdf->download('expenses_' . strtolower(str_replace(' ', '_', $profile->name)) . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Impossible de générer le PDF : ' . $e->getMessage());
        }
    }

    public function printSummary($profileId)
    {
        $profile = Profile::findOrFail($profileId);

        $totals = $this->calculateTotals($profileId);
        $incomeNeeded = $this->calculateIncomeNeeded($profileId);

        $pdf = Pdf::loadView('expenses.summary_pdf', compact('profile', 'totals', 'incomeNeeded'));

        return $pdf->download('profile_' . $profile->id . '_summary.pdf');
    }
}
