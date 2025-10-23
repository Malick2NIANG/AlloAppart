<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Appartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    /**
     * Enregistrer un avis sur un appartement.
     */
    public function store(Request $request, $id)
    {
        // ✅ Validation élégante avec messages personnalisés
        $validated = $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string|max:1000',
        ], [
            'note.required' => 'Veuillez sélectionner une note entre 1 et 5 étoiles.',
            'commentaire.required' => 'Veuillez écrire un commentaire avant d’envoyer votre avis.',
        ]);

        // ✅ Récupérer l’appartement
        $appartement = Appartement::findOrFail($id);

        // ✅ Empêcher les doublons d’avis
        $existing = Avis::where('user_id', Auth::id())
            ->where('appartement_id', $appartement->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Vous avez déjà laissé un avis pour cet appartement.');
        }

        // ✅ Créer l’avis
        Avis::create([
            'user_id' => Auth::id(),
            'appartement_id' => $appartement->id,
            'note' => $validated['note'],
            'commentaire' => $validated['commentaire'],
        ]);

        // ✅ Redirection + message de succès stylé
        return back()->with('success', '✨ Merci pour votre avis ! Il a été enregistré avec succès.');
    }
}
