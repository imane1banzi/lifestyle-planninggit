<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Affiche la vue de création d'une catégorie.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Stocke une nouvelle catégorie dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_required' => 'required|boolean',
            'is_active' => 'required|boolean',
        ]);

        Category::create($request->only(['name', 'is_required', 'is_active']));

        return redirect()->route('categories.manage')->with('success', 'Category added successfully!');
    }
    /**
     * Affiche la liste des catégories.
     */
    public function index()
    {
        // Charger les catégories avec leurs items
        $categories = Category::with('items')->get();
        return view('categories.manage', compact('categories'));
    }
    public function manage()
    {
        $categories = Category::with('items')->get(); // Charger les catégories et leurs items
        return view('categories.manage', compact('categories'));
    }
    public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('categories.edit', compact('category'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'is_required' => 'required|boolean',
        'is_active' => 'required|boolean',
    ]);

    $category = Category::findOrFail($id);
    $category->update($request->only(['name', 'is_required', 'is_active']));

    return redirect()->route('categories.manage')->with('success', 'Category updated successfully!');
}

public function destroy($id)
{
    $category = Category::findOrFail($id);
    $category->delete();

    return redirect()->route('categories.manage')->with('success', 'Category deleted successfully!');
}

}
