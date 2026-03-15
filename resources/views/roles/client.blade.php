{{-- resources/views/roles/client.blade.php --}}
@extends('layouts.front')

@section('title', 'Espace Client — AlloAppart')
@section('meta_description', 'Votre espace client AlloAppart : recommandations, favoris, messages, avis, et annonces récemment consultées.')

@section('content')
@php
    $user = auth()->user();

    // ✅ Données attendues depuis le controller (fallback safe si non fourni)
    $favoris = $favoris ?? $user->favoris()->with('images')->latest()->take(8)->get();

    $messages = $messages ?? \App\Models\Message::with([
            'destinataire:id,nom,email',
            'appartement:id,titre,ville,prix'
        ])->where('user_id', $user->id)->latest()->take(6)->get();

    // ⚠️ IMPORTANT : colonne "lu" (tinyint 0/1)
    $nonLusCount = $nonLusCount ?? \App\Models\Message::where('user_id', $user->id)->where('lu', 0)->count();

    $avis = $avis ?? \App\Models\Avis::with('appartement:id,titre,ville,prix')
        ->where('user_id', $user->id)->latest()->take(4)->get();

    // Compteurs (idéalement depuis controller)
    $favorisCount  = $favorisCount  ?? $user->favoris()->count();
    $messagesCount = $messagesCount ?? \App\Models\Message::where('user_id',$user->id)->count();
    $avisCount     = $avisCount     ?? \App\Models\Avis::where('user_id',$user->id)->count();

    // Optionnel (à brancher plus tard)
    $recommandes = $recommandes ?? collect([]);
    $recents = $recents ?? collect([]);

    $imgOf = function ($app) {
        $first = optional($app->images->first())->url;
        return $first ? asset('storage/'.$first) : 'https://via.placeholder.com/800x520?text=AlloAppart';
    };

    $fmt = fn ($n) => number_format((float)$n, 0, ',', ' ');

    $hour = (int) now()->format('H');
    $greet = $hour < 12 ? "Bonjour" : ($hour < 18 ? "Bon après-midi" : "Bonsoir");
@endphp

<section class="aa-container mx-auto px-4 sm:px-6 pt-10 pb-16">

    {{-- ============================ HERO ============================ --}}
    <div class="relative overflow-hidden rounded-3xl border aa-border bg-white/70 backdrop-blur-xl shadow-xl">
        <div class="absolute inset-0 pointer-events-none opacity-70"
             style="background:
                radial-gradient(900px 320px at 15% 10%, rgba(250,204,21,.35), transparent 60%),
                radial-gradient(800px 320px at 85% 0%, rgba(181,137,0,.25), transparent 55%),
                radial-gradient(700px 300px at 70% 90%, rgba(15,23,42,.10), transparent 55%);">
        </div>

        <div class="relative p-6 md:p-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                <div class="min-w-0">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/80 border aa-border text-xs text-gray-700">
                        <span class="h-2 w-2 rounded-full bg-[#facc15]"></span>
                        Session : <span class="font-semibold">Client</span>
                    </div>

                    <h1 class="mt-4 text-3xl md:text-4xl font-extrabold tracking-tight text-[#1C1C1C]">
                        {{ $greet }}, <span class="text-[#b58900]">{{ $user->nom }}</span>
                    </h1>

                    <p class="mt-2 text-gray-600 max-w-2xl">
                        Accédez à vos favoris, messages et avis. Explorez des logements adaptés à vos préférences.
                    </p>

                    {{-- Stats rapides --}}
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="rounded-2xl border aa-border bg-white/70 p-4">
                            <div class="text-xs text-gray-500">Favoris</div>
                            <div class="text-2xl font-extrabold text-gray-900">{{ $favorisCount }}</div>
                        </div>
                        <div class="rounded-2xl border aa-border bg-white/70 p-4">
                            <div class="text-xs text-gray-500">Messages</div>
                            <div class="text-2xl font-extrabold text-gray-900">{{ $messagesCount }}</div>
                        </div>
                        <div class="rounded-2xl border aa-border bg-white/70 p-4">
                            <div class="text-xs text-gray-500">Non lus</div>
                            <div class="text-2xl font-extrabold text-gray-900">{{ $nonLusCount }}</div>
                        </div>
                        <div class="rounded-2xl border aa-border bg-white/70 p-4">
                            <div class="text-xs text-gray-500">Avis</div>
                            <div class="text-2xl font-extrabold text-gray-900">{{ $avisCount }}</div>
                        </div>
                    </div>

                    {{-- Search --}}
                    <form action="{{ route('front.index') }}" method="GET" class="mt-6">
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="flex-1">
                                <label class="sr-only" for="q">Rechercher</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                    <input id="q" name="q" type="text" placeholder="Ville, quartier, type de logement..."
                                           class="w-full pl-11 pr-4 py-3 rounded-2xl border aa-border bg-white/90 focus:ring-2 focus:ring-[#facc15] focus:outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:flex gap-3">
                                <button type="submit"
                                        class="btn-gold px-6 py-3 rounded-2xl font-semibold hover:scale-[1.01] transition">
                                    Rechercher
                                </button>
                                <a href="{{ route('front.index') }}"
                                   class="px-6 py-3 rounded-2xl font-semibold border aa-border bg-white/90 hover:bg-white transition text-center">
                                    Explorer
                                </a>
                            </div>
                        </div>

                        {{-- Filtres rapides --}}
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('front.index', ['ville' => 'Dakar']) }}"
                               class="px-3 py-1.5 text-sm rounded-full border aa-border bg-white/80 hover:bg-white transition">
                                Dakar
                            </a>
                            <a href="{{ route('front.index', ['chambres' => 1]) }}"
                               class="px-3 py-1.5 text-sm rounded-full border aa-border bg-white/80 hover:bg-white transition">
                                1 chambre
                            </a>
                            <a href="{{ route('front.index', ['chambres' => 2]) }}"
                               class="px-3 py-1.5 text-sm rounded-full border aa-border bg-white/80 hover:bg-white transition">
                                2 chambres
                            </a>
                            <a href="{{ route('front.index', ['max' => 150000]) }}"
                               class="px-3 py-1.5 text-sm rounded-full border aa-border bg-white/80 hover:bg-white transition">
                                ≤ 150 000 FCFA
                            </a>
                            <a href="{{ route('front.index', ['statut' => 'disponible']) }}"
                               class="px-3 py-1.5 text-sm rounded-full border aa-border bg-white/80 hover:bg-white transition">
                                Disponibles
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Carte profil / actions --}}
                <div class="w-full lg:w-[380px] shrink-0">
                    <div class="rounded-3xl border aa-border bg-white/80 backdrop-blur-xl shadow-lg p-6">
                        <div class="flex items-center gap-4">
                            <div class="h-14 w-14 rounded-2xl bg-[#fff5d6] border border-[#facc15]/40 grid place-items-center text-[#b58900] font-extrabold text-lg">
                                {{ $user->initials() }}
                            </div>
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900 truncate">{{ $user->nom }}</div>
                                <div class="text-sm text-gray-600 truncate">{{ $user->email }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $user->telephone ?? 'Téléphone non renseigné' }}</div>
                            </div>
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-3">
                            <a href="{{ route('favoris.index') }}"
                               class="px-4 py-3 rounded-2xl border aa-border bg-white hover:bg-gray-50 transition flex items-center gap-2 justify-center">
                                <i class="fa-solid fa-heart text-[#b58900]"></i>
                                <span class="text-sm font-semibold">Favoris</span>
                            </a>

                            <a href="{{ route('messages.index') }}"
                               class="relative px-4 py-3 rounded-2xl border aa-border bg-white hover:bg-gray-50 transition flex items-center gap-2 justify-center">
                                <i class="fa-solid fa-comments text-[#b58900]"></i>
                                <span class="text-sm font-semibold">Messages</span>
                                @if($nonLusCount > 0)
                                    <span class="absolute -top-2 -right-2 h-6 min-w-[24px] px-2 grid place-items-center rounded-full bg-[#facc15] text-[#1C1C1C] text-xs font-extrabold shadow">
                                        {{ $nonLusCount }}
                                    </span>
                                @endif
                            </a>

                            <a href="{{ route('profile.edit') }}"
                               class="px-4 py-3 rounded-2xl border aa-border bg-white hover:bg-gray-50 transition flex items-center gap-2 justify-center">
                                <i class="fa-solid fa-user-gear text-[#b58900]"></i>
                                <span class="text-sm font-semibold">Profil</span>
                            </a>

                            <a href="{{ route('password.edit') }}"
                               class="px-4 py-3 rounded-2xl border aa-border bg-white hover:bg-gray-50 transition flex items-center gap-2 justify-center">
                                <i class="fa-solid fa-key text-[#b58900]"></i>
                                <span class="text-sm font-semibold">Sécurité</span>
                            </a>
                        </div>

                        <div class="mt-4 text-xs text-gray-500 leading-relaxed">
                            Conseil : ajoutez des favoris pour comparer rapidement les annonces.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================ SECTIONS ============================ --}}
    <div class="mt-10 grid lg:grid-cols-3 gap-8">

        {{-- ========= COLONNE PRINCIPALE ========= --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Recommandés --}}
            <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-6 md:p-7 shadow-lg">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-wand-magic-sparkles text-[#b58900]"></i>
                        Recommandés
                    </h2>
                    <a href="{{ route('front.index') }}"
                       class="text-sm text-[#b58900] hover:text-[#8a6a00] font-semibold transition">
                        Voir tout →
                    </a>
                </div>

                @if($recommandes->count())
                    <div class="mt-5 grid sm:grid-cols-2 md:grid-cols-3 gap-5">
                        @foreach($recommandes as $app)
                            @php $img = $imgOf($app); @endphp
                            <a href="{{ route('front.show', $app->id) }}"
                               class="group rounded-2xl overflow-hidden border aa-border bg-white/70 hover:shadow-lg transition">
                                <div class="relative">
                                    <img src="{{ $img }}" alt="{{ $app->titre }}"
                                         class="h-36 w-full object-cover group-hover:scale-105 transition duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-transparent to-transparent opacity-60"></div>
                                </div>
                                <div class="p-3">
                                    <div class="font-semibold text-gray-900 truncate group-hover:text-[#b58900] transition">
                                        {{ $app->titre }}
                                    </div>
                                    <div class="text-sm text-gray-600">{{ $app->ville }} • {{ $app->chambres }} ch</div>
                                    <div class="text-[#b58900] font-extrabold mt-1">
                                        {{ $fmt($app->prix) }} FCFA
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="mt-5 rounded-2xl border aa-border bg-white/70 p-5 flex items-start gap-4">
                        <div class="h-11 w-11 rounded-xl bg-[#fff5d6] border border-[#facc15]/40 grid place-items-center text-[#b58900]">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="font-semibold text-gray-900">Aucune recommandation pour l’instant</div>
                            <div class="text-sm text-gray-600">
                                Parcourez quelques annonces et ajoutez des favoris pour activer les recommandations.
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Récents --}}
            <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-6 md:p-7 shadow-lg">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-[#b58900]"></i>
                        Récemment consultés
                    </h2>
                    <a href="{{ route('front.index') }}"
                       class="text-sm text-[#b58900] hover:text-[#8a6a00] font-semibold transition">
                        Explorer →
                    </a>
                </div>

                @if($recents->count())
                    <div class="mt-5 grid sm:grid-cols-2 md:grid-cols-3 gap-5">
                        @foreach($recents as $app)
                            @php $img = $imgOf($app); @endphp
                            <a href="{{ route('front.show', $app->id) }}"
                               class="group rounded-2xl overflow-hidden border aa-border bg-white/70 hover:shadow-lg transition">
                                <img src="{{ $img }}" alt="{{ $app->titre }}"
                                     class="h-36 w-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="p-3">
                                    <div class="font-semibold text-gray-900 truncate group-hover:text-[#b58900] transition">
                                        {{ $app->titre }}
                                    </div>
                                    <div class="text-sm text-gray-600">{{ $app->ville }} • {{ $app->chambres }} ch</div>
                                    <div class="text-[#b58900] font-extrabold mt-1">
                                        {{ $fmt($app->prix) }} FCFA
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="mt-5 rounded-2xl border aa-border bg-white/70 p-5 flex items-start gap-4">
                        <div class="h-11 w-11 rounded-xl bg-[#fff5d6] border border-[#facc15]/40 grid place-items-center text-[#b58900]">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="font-semibold text-gray-900">Aucun historique</div>
                            <div class="text-sm text-gray-600">
                                Les annonces consultées apparaîtront ici.
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Messages --}}
            <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-6 md:p-7 shadow-lg">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl md:text-2xl font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-comments text-[#b58900]"></i>
                            Messages
                        </h2>
                        @if($nonLusCount > 0)
                            <span class="px-2 py-1 text-xs rounded-full bg-[#fff5d6] text-[#b58900] border border-[#facc15]/50">
                                {{ $nonLusCount }} non lus
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('messages.index') }}"
                       class="text-sm text-[#b58900] hover:text-[#8a6a00] font-semibold transition">
                        Voir tout →
                    </a>
                </div>

                @if($messages->count())
                    <div class="mt-5 space-y-3">
                        @foreach($messages as $m)
                            <div class="rounded-2xl border aa-border bg-white/70 p-4 hover:shadow-md transition">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="text-xs text-gray-500">Appartement</div>
                                        <div class="font-semibold text-gray-900 truncate">
                                            {{ $m->appartement->titre ?? '—' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ optional($m->created_at)->diffForHumans() }}
                                        </div>
                                    </div>

                                    <div class="shrink-0">
                                        @if(!$m->lu)
                                            <span class="px-2 py-1 text-xs rounded-full bg-[#fff5d6] text-[#b58900] border border-[#facc15]/50">Non lu</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 border border-green-200">Lu</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3 text-sm text-gray-700 line-clamp-2">
                                    {{ $m->contenu }}
                                </div>

                                <div class="mt-4 flex items-center justify-between gap-3">
                                    <div class="text-xs text-gray-600">
                                        Bailleur :
                                        <span class="font-semibold text-gray-900">{{ $m->destinataire->nom ?? '—' }}</span>
                                    </div>

                                    <a href="{{ route('front.show', $m->appartement_id) }}"
                                       class="text-sm font-semibold text-[#b58900] hover:text-[#8a6a00] transition">
                                        Ouvrir l’annonce →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-5 rounded-2xl border aa-border bg-white/70 p-5 flex items-start gap-4">
                        <div class="h-11 w-11 rounded-xl bg-[#fff5d6] border border-[#facc15]/40 grid place-items-center text-[#b58900]">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="font-semibold text-gray-900">Aucun message</div>
                            <div class="text-sm text-gray-600">
                                Contactez un bailleur depuis une annonce.
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        {{-- ========= COLONNE DROITE ========= --}}
        <aside class="lg:col-span-1 space-y-8">

            {{-- Favoris --}}
            <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-6 shadow-lg">
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-heart text-[#b58900]"></i>
                        Favoris
                    </h3>
                    <a href="{{ route('favoris.index') }}"
                       class="text-sm text-[#b58900] hover:text-[#8a6a00] font-semibold transition">
                        Tout voir →
                    </a>
                </div>

                @if($favoris->count())
                    <div class="mt-4 space-y-3">
                        @foreach($favoris->take(6) as $f)
                            @php $img = $imgOf($f); @endphp
                            <a href="{{ route('front.show', $f->id) }}"
                               class="group flex gap-3 rounded-2xl border aa-border bg-white/70 p-3 hover:shadow-md transition">
                                <img src="{{ $img }}" alt="{{ $f->titre }}" class="h-16 w-20 rounded-xl object-cover">
                                <div class="min-w-0">
                                    <div class="font-semibold text-gray-900 truncate group-hover:text-[#b58900] transition">
                                        {{ $f->titre }}
                                    </div>
                                    <div class="text-xs text-gray-600">{{ $f->ville }} • {{ $f->chambres }} ch</div>
                                    <div class="text-sm font-extrabold text-[#b58900] mt-0.5">
                                        {{ $fmt($f->prix) }} FCFA
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="mt-4 rounded-2xl border aa-border bg-white/70 p-5 text-sm text-gray-600">
                        Aucun favori. <a class="text-[#b58900] font-semibold hover:underline" href="{{ route('front.index') }}">Explorer le catalogue</a>.
                    </div>
                @endif
            </div>

            {{-- Avis --}}
            <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-6 shadow-lg">
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-star text-[#b58900]"></i>
                        Avis
                    </h3>
                </div>

                @if($avis->count())
                    <div class="mt-4 space-y-3">
                        @foreach($avis as $a)
                            <div class="rounded-2xl border aa-border bg-white/70 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-900 truncate">
                                            {{ $a->appartement->titre ?? 'Appartement' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ optional($a->created_at)->diffForHumans() }}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1 text-[#facc15]">
                                        @for($i=1; $i<=5; $i++)
                                            @if($i <= (int)$a->note)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                @if($a->commentaire)
                                    <div class="mt-3 text-sm text-gray-700 line-clamp-2">
                                        {{ $a->commentaire }}
                                    </div>
                                @endif

                                @if($a->appartement_id)
                                    <div class="mt-3">
                                        <a href="{{ route('front.show', $a->appartement_id) }}"
                                           class="text-sm font-semibold text-[#b58900] hover:text-[#8a6a00] transition">
                                            Revoir l’annonce →
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-4 rounded-2xl border aa-border bg-white/70 p-5 text-sm text-gray-600">
                        Aucun avis pour le moment.
                    </div>
                @endif
            </div>

            {{-- Sécurité / Préférences --}}
            <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-[#b58900]"></i>
                    Sécurité & Préférences
                </h3>

                <ul class="mt-4 space-y-2 text-sm text-gray-700">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-[#b58900] mt-0.5"></i>
                        Activez la double authentification (2FA) pour renforcer votre compte.
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-[#b58900] mt-0.5"></i>
                        Personnalisez l’apparence selon votre confort de lecture.
                    </li>
                </ul>

                <div class="mt-5 grid grid-cols-2 gap-3">
                    <a href="{{ route('two-factor.show') }}"
                       class="px-4 py-2.5 rounded-2xl border aa-border bg-white hover:bg-gray-50 transition text-center text-sm font-semibold">
                        2FA
                    </a>
                    <a href="{{ route('appearance.edit') }}"
                       class="px-4 py-2.5 rounded-2xl border aa-border bg-white hover:bg-gray-50 transition text-center text-sm font-semibold">
                        Apparence
                    </a>
                </div>
            </div>

        </aside>
    </div>

</section>

<style>
@media (min-width: 1024px){
  .aa-container{ max-width: 1200px; }
}
.line-clamp-2{
  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
}
</style>
@endsection
