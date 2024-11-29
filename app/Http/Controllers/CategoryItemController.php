<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryItem;
use Illuminate\Http\Request;

class CategoryItemController extends Controller
{
    /**
     * Affiche la liste des items avec leurs catégories associées.
     */
    public function index()
    {
        $items = CategoryItem::with('category')->paginate(10); // 10 résultats par page
        return view('category_items.index', compact('items'));
    }

    /**
     * Affiche le formulaire de création d'un Category Item.
     */
    public function create()
    {
        $categories = Category::all(); // Récupérer toutes les catégories pour le menu déroulant
        return view('category_items.create', compact('categories'));
    }

    /**
     * Stocke un nouvel item dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'monthly_cost' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        CategoryItem::create($request->only(['name', 'monthly_cost', 'description', 'category_id']));

        return redirect()->route('categories.manage')->with('success', 'Category Item added successfully!');
    }

    /**
     * Affiche le formulaire d'édition pour un Category Item.
     */
    public function edit($id)
{
    $item = CategoryItem::findOrFail($id);
    $categories = Category::all(); // Pour le menu déroulant des catégories
    return view('category_items.edit', compact('item', 'categories'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'monthly_cost' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
    ]);

    $item = CategoryItem::findOrFail($id);
    $item->update($request->only(['name', 'monthly_cost', 'description', 'category_id']));

    return redirect()->route('categories.manage')->with('success', 'Item updated successfully!');
}

public function destroy($id)
{
    $item = CategoryItem::findOrFail($id);
    $item->delete();

    return redirect()->route('categories.manage')->with('success', 'Item deleted successfully!');
}

    
    
}

