<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    public function __construct()
    {
        // Tout le contrôleur nécessite un utilisateur connecté
        // (si tu veux autoriser toggle sans middleware, garde "except(['toggle'])")
        $this->middleware('auth');
    }

    /**
     * 🧡 Affiche la page “Mes favoris”.
     */
    public function index()
    {
        $user = Auth::user();

        $favoris = $user->favoris()
            ->with('images')
            ->paginate(12);

        return view('front.favoris', compact('favoris'));
    }

    /**
     * ❤️ Ajoute ou retire un appartement des favoris.
     */
    public function toggle(Request $request, Appartement $appartement)
    {
        $user = Auth::user();

        // Toggle simple via pivot
        $already = $user->favoris()->where('appartement_id', $appartement->id)->exists();

        if ($already) {
            $user->favoris()->detach($appartement->id);
            $added = false;
            $message = "Retiré des favoris.";
        } else {
            $user->favoris()->attach($appartement->id);
            $added = true;
            $message = "Ajouté aux favoris ❤️";
        }

        if ($request->expectsJson()) {
            return response()->json([
                'added' => $added,
                'count' => $user->favoris()->count(),
                'message' => $message,
                'appartement_id' => $appartement->id,
            ]);
        }

        return back()->with($added ? 'success' : 'info', $message);
    }
}
