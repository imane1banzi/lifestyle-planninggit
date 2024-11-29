<?php
namespace App\Http\Controllers;

use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    /**
     * Affiche la liste des recommandations.
     */
    public function index()
    {
        $recommendations = Recommendation::paginate(10); // Pagination des résultats
        return view('recommendations.index', compact('recommendations'));
    }

    /**
     * Affiche le formulaire de création d'une recommandation.
     */
    public function create()
    {
        return view('recommendations.create');
    }

    /**
     * Stocke une nouvelle recommandation dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profession_name' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Recommendation::create($request->all());

        return redirect()->route('recommendations.index')->with('success', 'Recommendation added successfully!');
    }

    /**
     * Affiche le formulaire d'édition pour une recommandation.
     */
    public function edit(Recommendation $recommendation)
    {
        return view('recommendations.edit', compact('recommendation'));
    }

    /**
     * Met à jour une recommandation existante.
     */
    public function update(Request $request, Recommendation $recommendation)
    {
        $request->validate([
            'profession_name' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $recommendation->update($request->all());

        return redirect()->route('recommendations.index')->with('success', 'Recommendation updated successfully!');
    }

    /**
     * Supprime une recommandation.
     */
    public function destroy(Recommendation $recommendation)
    {
        $recommendation->delete();

        return redirect()->route('recommendations.index')->with('success', 'Recommendation deleted successfully!');
    }
}
