<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    /**
     * Ajoute ou retire un appartement des favoris.
     */
    public function toggle(Request $request, Appartement $appartement)
    {
        // 🔒 Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            // Si non connecté → redirection vers login
            return redirect()->route('login')->with('warning', 'Veuillez vous connecter pour gérer vos favoris.');
        }

        $user = Auth::user();

        // Vérifie si l'appartement est déjà en favoris
        $isAlreadyFav = $user->favoris()->where('appartement_id', $appartement->id)->exists();

        if ($isAlreadyFav) {
            // ✅ Si déjà en favoris → on retire
            $user->favoris()->detach($appartement->id);
            $added = false;
            $message = "Retiré des favoris.";
        } else {
            // ❤️ Sinon → on ajoute
            $user->favoris()->attach($appartement->id);
            $added = true;
            $message = "Ajouté aux favoris ❤️";
        }

        // 🔁 Si c’est un appel AJAX → retour JSON (utile si tu veux le rendre dynamique plus tard)
        if ($request->expectsJson()) {
            return response()->json([
                'added' => $added,
                'count' => $user->favoris()->count(),
                'message' => $message,
                'appartement_id' => $appartement->id,
            ]);
        }

        // 🔙 Sinon → redirection classique avec message flash
        return back()->with($added ? 'success' : 'info', $message);
    }
}
