<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuickStartController extends Controller
{
    /**
     * Affiche la page principale Quick Start avec les catégories, items et profils stockés en session.
     */
    public function index()
    {
        // Récupérer les catégories et leurs items depuis la session
        $categories = session('categories', []);
        $profiles = session('profiles', []); // Profils stockés en session

        // Calculer le total de chaque catégorie
        foreach ($categories as &$category) {
            $category['total_cost'] = array_reduce($category['items'] ?? [], function ($total, $item) {
                return $total + $item['monthly_cost'];
            }, 0);
        }

        return view('quick-start.index', compact('categories', 'profiles'));
    }

    /**
     * Ajoute un profil et le stocke en session.
     */
    public function createProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $profile = [
            'id' => uniqid(),
            'name' => $request->name,
        ];

        session()->push('profiles', $profile);

        return redirect()->route('quick.index')->with('success', 'Profile created successfully!');
    }

    /**
     * Ajoute une catégorie et la stocke en session.
     */
    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = [
            'id' => uniqid(),
            'name' => $request->name,
            'items' => [],
        ];

        session()->push('categories', $category);

        return redirect()->route('quick.index')->with('success', 'Category added successfully!');
    }

    /**
     * Ajoute un item à une catégorie existante et le stocke en session.
     */
    public function addCategoryItem(Request $request)
    {
        $request->validate([
            'category_id' => 'required|string',
            'name' => 'required|string|max:255',
            'monthly_cost' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $categories = session('categories', []);

        foreach ($categories as &$category) {
            if ($category['id'] === $request->category_id) {
                $category['items'][] = [
                    'id' => uniqid(),
                    'name' => $request->name,
                    'monthly_cost' => $request->monthly_cost,
                    'description' => $request->description,
                ];
                break;
            }
        }

        session(['categories' => $categories]);

        return redirect()->route('quick.index')->with('success', 'Category item added successfully!');
    }

    /**
     * Ajoute une dépense basée sur une catégorie et la stocke en session.
     */
    public function createExpense(Request $request)
    {
        $request->validate([
            'category_id' => 'required|string',
            'profile_id' => 'required|string',
        ]);

        $categories = session('categories', []);
        $category = collect($categories)->firstWhere('id', $request->category_id);

        if (!$category) {
            return back()->withErrors(['category_id' => 'Category not found']);
        }

        $totalCost = array_reduce($category['items'] ?? [], function ($total, $item) {
            return $total + $item['monthly_cost'];
        }, 0);

        $expense = [
            'category' => $category['name'],
            'amount' => $totalCost,
            'profile_id' => $request->profile_id,
        ];

        session()->push('expenses', $expense);

        return redirect()->route('quick.summary')->with('success', 'Expense added successfully!');
    }

    /**
     * Affiche le résumé des profils, catégories, items et dépenses.
     */
    public function summary()
    {
        $profiles = session('profiles', []);
        $expenses = session('expenses', []);

        $profileTotals = [];

        foreach ($profiles as $profile) {
            $profileTotals[$profile['id']] = [
                'categories' => [],
                'monthly' => 0,
                'yearly' => 0,
                'biweekly' => 0,
                'hourly' => 0,
            ];

            foreach ($expenses as $expense) {
                if ($expense['profile_id'] === $profile['id']) {
                    $category = $expense['category'];
                    $profileTotals[$profile['id']]['categories'][$category] = ($profileTotals[$profile['id']]['categories'][$category] ?? 0) + $expense['amount'];
                }
            }

            $profileTotals[$profile['id']]['monthly'] = array_sum($profileTotals[$profile['id']]['categories']);
            $profileTotals[$profile['id']]['yearly'] = $profileTotals[$profile['id']]['monthly'] * 12;
            $profileTotals[$profile['id']]['biweekly'] = $profileTotals[$profile['id']]['monthly'] / 2;
            $profileTotals[$profile['id']]['hourly'] = $profileTotals[$profile['id']]['monthly'] / 160; // 160 heures travaillées par mois
        }

        return view('quick-start.summary', compact('profiles', 'profileTotals'));
    }
}
