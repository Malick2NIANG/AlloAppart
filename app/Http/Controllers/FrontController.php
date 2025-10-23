<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Message;
use App\Models\Avis; // ← à créer si tu veux gérer les avis
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FrontController extends Controller
{
    /**
     * 🏠 Page d'accueil - Liste filtrée d'appartements dans la région de Dakar
     */
    public function index(Request $request)
    {
        $communesDakar = [
            'Dakar', 'Pikine', 'Guédiawaye', 'Rufisque', 'Keur Massar',
            'Yoff', 'Ngor', 'Ouakam', 'Hann Bel-Air', 'Parcelles Assainies',
            'Grand Yoff', 'Mermoz', 'Sicap', 'Liberté', 'Medina', 'Colobane'
        ];

        $query = Appartement::with(['images:id,appartement_id,url', 'bailleur:id,nom,email,telephone'])
            ->select('id','user_id','titre','description','adresse','ville','prix','chambres','salles_de_bain','surface','statut','created_at')
            ->whereIn('ville', $communesDakar)
            ->where('statut', 'disponible');

        // 🔍 Recherche texte
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('titre', 'like', "%{$request->q}%")
                  ->orWhere('description', 'like', "%{$request->q}%")
                  ->orWhere('adresse', 'like', "%{$request->q}%")
                  ->orWhere('ville', 'like', "%{$request->q}%");
            });
        }

        // 🏙️ Filtres ville / type / prix / chambres
        if ($request->filled('ville')) $query->where('ville', 'like', "%{$request->ville}%");
        if ($request->filled('type')) $query->where('type', $request->type);
        if ($request->filled('min'))  $query->where('prix', '>=', (int) $request->min);
        if ($request->filled('max'))  $query->where('prix', '<=', (int) $request->max);

        if ($request->filled('chambres')) {
            $nb = (int) $request->chambres;
            $nb >= 4 ? $query->where('chambres', '>=', 4) : $query->where('chambres', $nb);
        }

        // 📅 Pagination fluide
        $appartements = $query->orderByDesc('created_at')->paginate(12);

        // ⚡ Si requête AJAX (filtrage instantané)
        if ($request->ajax()) {
            return view('front.partials.appartements', compact('appartements'))->render();
        }

        return view('front.index', compact('appartements'));
    }

    /**
     * 🏘️ Détail d’un appartement
     * → + similaires
     * → + avis (si table "avis")
     * → + compteur de vues
     */
    public function show($id)
    {
        $appartement = Appartement::with(['images', 'bailleur'])->findOrFail($id);

        // 📈 Compteur de vues (incrémentation simple en base)
        $appartement->increment('views');

        // 🧠 Statistiques
        $views = $appartement->views ?? 0;

        // 🏘️ Appartements similaires
        $similaires = Appartement::with(['images'])
            ->where('id', '!=', $appartement->id)
            ->where('ville', $appartement->ville)
            ->whereBetween('prix', [$appartement->prix * 0.8, $appartement->prix * 1.2])
            ->where('statut', 'disponible')
            ->limit(6)
            ->get();

        // ⭐ Avis (si tu veux cette fonctionnalité)
        $avis = collect();
        if (class_exists(Avis::class)) {
            $avis = Avis::where('appartement_id', $appartement->id)
                        ->latest()
                        ->take(10)
                        ->get();
        }

        return view('front.show', compact('appartement', 'similaires', 'avis', 'views'));
    }

    /**
     * ✉️ Envoi d’un message au bailleur (utilisateur connecté)
     */
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'contenu' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        $appartement = Appartement::findOrFail($id);

        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Veuillez vous connecter pour envoyer un message.');
        }

        Message::create([
            'user_id'        => Auth::id(),
            'bailleur_id'    => $appartement->user_id,
            'appartement_id' => $appartement->id,
            'contenu'        => $request->contenu,
            'lu'             => false,
        ]);

        return back()->with('success', 'Votre message a été envoyé au bailleur.');
    }
}
