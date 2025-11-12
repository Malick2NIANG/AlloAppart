<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    /**
     * Applique le middleware d’authentification à toutes les routes du contrôleur,
     * sauf la route toggle (gérée manuellement dans la méthode).
     */
    public function __construct()
    {
        // ✅ Assure que le middleware est bien appelé sur un contrôleur étendant Controller
        $this->middleware('auth')->except(['toggle']);
    }

    /**
     * 🧡 Affiche la page “Mes favoris”.
     */
    public function index()
    {
        $user = Auth::user();

        // 🔍 Récupère les appartements favoris de l'utilisateur avec leurs images
        $favoris = $user->favoris()
            ->with('images')
            ->latest()
            ->paginate(12);

        return view('front.favoris', compact('favoris'));
    }

    /**
     * ❤️ Ajoute ou retire un appartement des favoris.
     */
    public function toggle(Request $request, Appartement $appartement)
    {
        // 🔒 Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            // Si non connecté → redirection vers login
            return redirect()
                ->route('login')
                ->with('warning', 'Veuillez vous connecter pour gérer vos favoris.');
        }

        $user = Auth::user();

        // 🔎 Vérifie si l'appartement est déjà dans les favoris
        $isAlreadyFav = $user->favoris()
            ->where('appartement_id', $appartement->id)
            ->exists();

        if ($isAlreadyFav) {
            // ✅ Si déjà favori → on retire
            $user->favoris()->detach($appartement->id);
            $added = false;
            $message = "Retiré des favoris.";
        } else {
            // ❤️ Sinon → on ajoute
            $user->favoris()->attach($appartement->id);
            $added = true;
            $message = "Ajouté aux favoris ❤️";
        }

        // 🔁 Réponse AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'added' => $added,
                'count' => $user->favoris()->count(),
                'message' => $message,
                'appartement_id' => $appartement->id,
            ]);
        }

        // 🔙 Sinon redirection classique avec message flash
        return back()->with($added ? 'success' : 'info', $message);
    }
}
