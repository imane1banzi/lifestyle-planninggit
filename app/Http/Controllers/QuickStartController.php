<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuickStartController extends Controller
{
    public function index()
    {
        return view('quick-start.index');
    }

    public function createProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Store profile in session
        $profile = [
            'id' => uniqid(),
            'name' => $request->name,
        ];
        
        session()->push('profiles', $profile);
        
        return redirect()->route('quick.summary');
    }

    public function createExpense(Request $request)
    {
        $request->validate([
            'category' => 'required|string|in:subscriptions,housing,food',
            'amount' => 'required|numeric',
            'profile_id' => 'required|string', // ID of the profile in session
        ]);

        // Store expense in session
        $expense = [
            'category' => $request->category,
            'amount' => $request->amount,
            'profile_id' => $request->profile_id,
        ];

        session()->push('expenses', $expense);

        return redirect()->route('quick.summary');
    }

    public function summary()
    {
        // Récupérer les profils et dépenses
        $profiles = session('profiles', []);
        $expenses = session('expenses', []);
    
        // Initialiser un tableau pour stocker les totaux par profil
        $profileTotals = [];
    
        foreach ($profiles as $profile) {
            $profileTotals[$profile['id']] = [
                'subscriptions' => 0,
                'housing' => 0,
                'food' => 0,
                'monthly' => 0,
                'yearly' => 0,
                'biweekly' => 0,
                'hourly' => 0,
                'income_needed' => 0,
                'monthly_income_needed' => 0,
                'hourly_income_needed' => 0,
            ];
    
            // Calcul des totaux des dépenses pour chaque profil
            foreach ($expenses as $expense) {
                if ($expense['profile_id'] == $profile['id']) {
                    $profileTotals[$profile['id']][$expense['category']] += $expense['amount'];
                }
            }
    
            // Calcul du total mensuel et annuel
            $profileTotals[$profile['id']]['monthly'] = array_sum($profileTotals[$profile['id']]);
            $profileTotals[$profile['id']]['yearly'] = $profileTotals[$profile['id']]['monthly'] * 12;
    
            // Calcul du Biweekly Total (bi-hebdomadaire)
            $profileTotals[$profile['id']]['biweekly'] = $profileTotals[$profile['id']]['monthly'] / 2;
    
            // Calcul du Hourly Total (horaire)
            $profileTotals[$profile['id']]['hourly'] = $profileTotals[$profile['id']]['monthly'] / 160; // 160 heures par mois
    
            // Calcul de l'Income Needed basé sur les dépenses mensuelles
            $profileTotals[$profile['id']]['income_needed'] = $profileTotals[$profile['id']]['monthly'];
    
            // Calcul du Monthly Income Needed
            $profileTotals[$profile['id']]['monthly_income_needed'] = $profileTotals[$profile['id']]['monthly'];
    
            // Calcul du Hourly Income Needed
            $profileTotals[$profile['id']]['hourly_income_needed'] = $profileTotals[$profile['id']]['monthly_income_needed'] / 160;
        }
    
        return view('quick-start.summary', compact('profiles', 'expenses', 'profileTotals'));
    }

    protected function calculateTotals($expenses)
    {
        $totals = [
            'subscriptions' => 0,
            'housing' => 0,
            'food' => 0,
            'monthly' => 0,
            'yearly' => 0,
        ];

        foreach ($expenses as $expense) {
            $totals[$expense['category']] += $expense['amount'];
        }

        $totals['monthly'] = array_sum($totals);
        $totals['yearly'] = $totals['monthly'] * 12;

        return $totals;
    }
}
