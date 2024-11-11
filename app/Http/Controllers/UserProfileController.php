<?php
// app/Http/Controllers/UserProfileController.php
namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        // Récupérer tous les profils de l'utilisateur connecté
        $profiles = Auth::user()->profiles;
        return view('profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Créer un nouveau profil associé à l'utilisateur authentifié
        $profile = new Profile([
            'name' => $request->name,
            'user_id' => Auth::id(), // Utiliser Auth pour obtenir l'ID de l'utilisateur connecté
        ]);

        $profile->save();

        return redirect()->route('profiles.index')->with('success', 'Profil créé avec succès.');
    }

    public function show(Profile $profile)
    {
        // Vérifier si le profil appartient à l'utilisateur authentifié
        if ($profile->user_id !== Auth::id()) {
            return abort(403, 'Accès refusé.');
        }

        return view('profiles.show', compact('profile'));
    }

    public function destroy(Profile $profile)
    {
        // Vérifier si le profil appartient à l'utilisateur authentifié avant de le supprimer
        if ($profile->user_id !== Auth::id()) {
            return abort(403, 'Accès refusé.');
        }

        $profile->delete();
        return redirect()->route('profiles.index')->with('success', 'Profil supprimé avec succès.');
    }
}
