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
        // Check if the user is authenticated; if not, retrieve all profiles
        $profiles = Auth::check() ? Auth::user()->profiles : Profile::all();
        return view('profiles.index', compact('profiles'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour créer un profil.');
        }
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (Auth::check()) {
            // Create a new profile associated with the authenticated user
            $profile = new Profile([
                'name' => $request->name,
                'user_id' => Auth::id(),
            ]);

            $profile->save();

            return redirect()->route('profiles.index')->with('success', 'Profil créé avec succès.');
        }

        return redirect()->route('login')->with('error', 'Vous devez être connecté pour créer un profil.');
    }

    public function show(Profile $profile)
    {
        // For unauthenticated users, allow viewing but restrict access to only public profiles
        if (Auth::check() && $profile->user_id === Auth::id()) {
            return view('profiles.show', compact('profile'));
        } elseif (!$profile->is_public) { // Assuming there's an 'is_public' attribute for public profiles
            return abort(403, 'Accès refusé.');
        }

        return view('profiles.show', compact('profile'));
    }

    public function destroy(Profile $profile)
    {
        if (!Auth::check() || $profile->user_id !== Auth::id()) {
            return abort(403, 'Accès refusé.');
        }

        $profile->delete();
        return redirect()->route('profiles.index')->with('success', 'Profil supprimé avec succès.');
    }
}
