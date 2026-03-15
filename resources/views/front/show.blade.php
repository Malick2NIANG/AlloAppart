{{-- resources/views/front/show.blade.php --}}
@extends('layouts.front')

@section('title', $appartement->titre)

@section('content')

{{-- Alpine.js pour carousel + lightbox + partages --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

@php
    // Images
    $images = $appartement->images->pluck('url')->map(fn($p) => asset('storage/'.$p))->values()->all();
    if (count($images) === 0) {
        $images = ['https://via.placeholder.com/1600x900?text=AlloAppart'];
    }

    // Prix formaté
    $price = number_format($appartement->prix, 0, ',', ' ');

    // URL courante (pour partage)
    $fullUrl = request()->fullUrl();

    // “Similaires” facultatif
    $similaires = $similaires ?? null;

    // “Avis” facultatif
    $avis = $avis ?? collect([]);
    $noteMoy = $avis->count() ? round($avis->avg('note'), 1) : null;

    // Compteur de vues transmis par le contrôleur
    $views = $views ?? null;

    // Favori actuel
    $isFavori = auth()->check() ? auth()->user()->favoris->contains($appartement->id) : false;
@endphp

{{-- ======================= FIL D’ARIANE ======================= --}}
<nav class="aa-container mx-auto px-4 sm:px-6 text-sm text-gray-500 mt-6 mb-5">
    <ol class="flex items-center gap-2">
        <li><a class="hover:text-[#b58900]" href="{{ route('front.index') }}">Accueil</a></li>
        <li class="text-gray-400">/</li>
        <li class="truncate">{{ $appartement->ville }}</li>
        <li class="text-gray-400">/</li>
        <li class="text-gray-800 font-medium truncate max-w-[50vw]">{{ $appartement->titre }}</li>
    </ol>
</nav>

{{-- ======================= HÉRO / CARROUSEL ======================= --}}
<section
    x-data="{
        index: 0,
        images: @js($images),
        get current(){ return this.images[this.index] },
        next(){ this.index = (this.index + 1) % this.images.length },
        prev(){ this.index = (this.index - 1 + this.images.length) % this.images.length },
        go(i){ this.index = i },
        lightbox:false
    }"
    class="aa-container mx-auto px-4 sm:px-6 relative overflow-hidden rounded-3xl border aa-border shadow-2xl mb-10 bg-[#0f172a]"
>
    {{-- Slider principal --}}
    <div class="relative group">
        <div class="w-full h-[56vh] sm:h-[62vh] md:h-[68vh] overflow-hidden">
            <template x-for="(src,i) in images" :key="i">
                <img
                    x-show="index===i"
                    x-transition.opacity
                    :src="src" :alt="'Photo '+(i+1)"
                    class="w-full h-full object-cover select-none"
                    loading="lazy"
                    @click="lightbox = true"
                    style="cursor: zoom-in"
                >
            </template>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent pointer-events-none"></div>
        </div>

        {{-- Flèches --}}
        <button @click="prev"
            class="opacity-0 group-hover:opacity-100 absolute left-3 top-1/2 -translate-y-1/2 bg-white/85 hover:bg-white text-gray-800 rounded-full h-10 w-10 grid place-items-center shadow-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <button @click="next"
            class="opacity-0 group-hover:opacity-100 absolute right-3 top-1/2 -translate-y-1/2 bg-white/85 hover:bg-white text-gray-800 rounded-full h-10 w-10 grid place-items-center shadow-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        </button>

        {{-- Bullets --}}
        <div class="absolute bottom-4 inset-x-0 flex justify-center gap-1.5">
            <template x-for="(src,i) in images" :key="'b'+i">
                <button @click="go(i)"
                    class="h-1.5 rounded-full transition"
                    :class="index===i ? 'w-6 bg-[#facc15]' : 'w-3 bg-white/60 hover:bg-white'"></button>
            </template>
        </div>

        {{-- Label compteur + favori + partager --}}
        <div class="absolute top-3 right-3 flex items-center gap-2">
            <div class="px-2 py-1 rounded-full bg-black/50 text-white text-xs">
                <span x-text="(index+1)+' / '+images.length"></span>
            </div>

            {{-- ✅ Favori (AJAX) --}}
            <form method="POST" action="{{ route('favoris.toggle', $appartement->id) }}"
                  class="favori-toggle-form">
                @csrf
                <button type="submit" title="Ajouter aux favoris"
                    class="h-9 w-9 grid place-items-center rounded-full bg-black/40 hover:bg-black/60 text-white transition"
                    data-appartement-id="{{ $appartement->id }}"
                    aria-label="Favori">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 transition-all duration-300 favori-heart"
                         fill="{{ $isFavori ? '#facc15' : 'none' }}"
                         viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                              2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09
                              C13.09 3.81 14.76 3 16.5 3
                              19.58 3 22 5.42 22 8.5
                              c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </button>
            </form>

            {{-- Partage --}}
            <div x-data="{open:false}" class="relative">
                <button @click="open=!open"
                    class="h-9 w-9 grid place-items-center rounded-full bg-black/40 hover:bg-black/60 text-white transition"
                    title="Partager">
                    <i class="fa-solid fa-share-nodes"></i>
                </button>
                <div x-show="open" @click.outside="open=false" x-transition
                    class="absolute right-0 mt-2 w-56 bg-white border aa-border rounded-xl shadow-lg p-2 z-10">
                    <a target="_blank" href="https://wa.me/?text={{ urlencode($appartement->titre.' - '.$fullUrl) }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50">
                        <i class="fa-brands fa-whatsapp text-green-600"></i> WhatsApp
                    </a>
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($fullUrl) }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50">
                        <i class="fa-brands fa-facebook text-blue-600"></i> Facebook
                    </a>
                    <a target="_blank" href="mailto:?subject={{ urlencode('AlloAppart - '.$appartement->titre) }}&body={{ urlencode($fullUrl) }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50">
                        <i class="fa-regular fa-envelope"></i> E-mail
                    </a>
                    <button
                        x-data
                        @click="navigator.clipboard.writeText('{{ $fullUrl }}'); $el.innerText='Lien copié !'; setTimeout(()=>{$el.innerText='Copier le lien';},1400);"
                        class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50">
                        <i class="fa-regular fa-copy"></i> Copier le lien
                    </button>
                </div>
            </div>
        </div>

        {{-- Titre flottant --}}
        <div class="absolute bottom-4 left-4 md:left-6 text-white drop-shadow-lg">
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">{{ $appartement->titre }}</h1>
            <p class="text-sm md:text-base text-gray-100">
                {{ $appartement->ville }} •
                <span class="text-[#facc15] font-semibold">{{ $price }} FCFA / mois</span>
            </p>
        </div>
    </div>

    {{-- Lightbox plein écran --}}
    <div x-show="lightbox" x-transition.opacity
        @keydown.escape.window="lightbox=false"
        class="fixed inset-0 z-[60] bg-black/90 backdrop-blur-sm flex flex-col">
        <div class="flex items-center justify-between p-4 text-white">
            <span class="text-sm opacity-80">Appuyez sur Échap pour fermer</span>
            <button @click="lightbox=false" class="h-10 w-10 grid place-items-center rounded-full bg-white/10 hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex-1 relative">
            <template x-for="(src,i) in images" :key="'L'+i">
                <img x-show="index===i" :src="src" class="absolute inset-0 m-auto max-h-[80vh] max-w-[92vw] object-contain"
                        @click="next" style="cursor: pointer" loading="lazy">
            </template>

            <button @click="prev"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-white/90 hover:text-white">
                <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button @click="next"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-white/90 hover:text-white">
                <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
        <div class="p-4">
            <div class="flex gap-2 overflow-x-auto">
                <template x-for="(src,i) in images" :key="'Lt'+i">
                    <button @click="go(i)" class="h-16 w-24 rounded-lg overflow-hidden border"
                        :class="index===i ? 'border-[#facc15]' : 'border-white/20'">
                        <img :src="src" class="h-full w-full object-cover" loading="lazy">
                    </button>
                </template>
            </div>
        </div>
    </div>
</section>

{{-- ======================= GRILLE CONTENU ======================= --}}
<section class="aa-container mx-auto px-4 sm:px-6 grid lg:grid-cols-3 gap-8">

    {{-- ========= COLONNE GAUCHE ========= --}}
    <div class="lg:col-span-2 space-y-8">

        <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-6 md:p-8 shadow-lg">
            <div class="flex flex-wrap items-center gap-3 justify-between">
                <h2 class="text-xl md:text-2xl font-semibold text-gray-900">À propos de ce logement</h2>

                <div class="flex items-center gap-2">
                    @if($appartement->created_at && now()->diffInDays($appartement->created_at) <= 10)
                        <span class="px-2.5 py-1 text-xs rounded-full bg-[#fff5d6] text-[#b58900] border border-[#facc15]/50">Nouveau</span>
                    @endif
                    @if($views !== null)
                        <span class="px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 border aa-border">
                            {{ $views }} vues
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm mt-5">
                <div class="flex items-center gap-2">
                    <span class="inline-grid place-items-center h-8 w-8 rounded-full bg-[#fff5d6] text-[#b58900]">
                        <i class="fa-solid fa-bed"></i>
                    </span>
                    <div><span class="font-medium text-gray-900">{{ $appartement->chambres }}</span> chambres</div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-grid place-items-center h-8 w-8 rounded-full bg-[#fff5d6] text-[#b58900]">
                        <i class="fa-solid fa-bath"></i>
                    </span>
                    <div><span class="font-medium text-gray-900">{{ $appartement->salles_de_bain ?? '—' }}</span> sdb</div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-grid place-items-center h-8 w-8 rounded-full bg-[#fff5d6] text-[#b58900]">
                        <i class="fa-solid fa-ruler-combined"></i>
                    </span>
                    <div><span class="font-medium text-gray-900">{{ $appartement->surface ?? '—' }}</span> m²</div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-grid place-items-center h-8 w-8 rounded-full bg-[#fff5d6] text-[#b58900]">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <div><span class="font-medium text-gray-900">{{ $appartement->adresse }}</span></div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-grid place-items-center h-8 w-8 rounded-full bg-[#fff5d6] text-[#b58900]">
                        <i class="fa-solid fa-city"></i>
                    </span>
                    <div><span class="font-medium text-gray-900">{{ $appartement->ville }}</span>, Dakar</div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-grid place-items-center h-8 w-8 rounded-full bg-[#fff5d6] text-[#b58900]">
                        <i class="fa-solid fa-door-open"></i>
                    </span>
                    <div><span class="font-medium text-gray-900 capitalize">{{ $appartement->statut }}</span></div>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                <p class="leading-relaxed text-gray-700">
                    {{ $appartement->description ?? 'Aucune description fournie.' }}
                </p>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Équipements</h3>
                <ul class="grid sm:grid-cols-2 md:grid-cols-3 gap-2 text-gray-700 text-sm">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-wifi text-[#b58900]"></i> Wifi haut débit</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-snowflake text-[#b58900]"></i> Climatisation</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-tv text-[#b58900]"></i> TV</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-utensils text-[#b58900]"></i> Cuisine équipée</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-shower text-[#b58900]"></i> Eau chaude</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-shield-halved text-[#b58900]"></i> Sécurité</li>
                </ul>
            </div>

            <div class="mt-6 text-sm">
                <a href="#" class="inline-flex items-center gap-1 text-gray-500 hover:text-[#b58900] transition">
                    <i class="fa-regular fa-flag"></i> Signaler cette annonce
                </a>
            </div>
        </div>

        @if($appartement->adresse)
            <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900">Localisation</h2>
                    <a target="_blank"
                        href="https://maps.google.com/?q={{ urlencode($appartement->adresse) }}"
                        class="text-sm text-[#b58900] hover:text-[#8a6a00] transition">Ouvrir dans Google Maps →</a>
                </div>
                <div class="mt-4">
                    <iframe
                        width="100%" height="360"
                        class="rounded-2xl border border-[#facc15]/30"
                        loading="lazy" allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q={{ urlencode($appartement->adresse) }}&output=embed">
                    </iframe>
                </div>
            </div>
        @endif

        {{-- Avis --}}
        @if($avis->count())
            <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xl font-semibold text-gray-900">Avis des locataires</h2>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <i class="fa-solid fa-star text-[#facc15]"></i>
                        <span class="font-medium">{{ $noteMoy }}</span>
                        <span class="text-gray-400">·</span>
                        <span>{{ $avis->count() }} avis</span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    @foreach($avis->take(6) as $av)
                        <div class="p-4 rounded-2xl border aa-border bg-white/60 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2">
                                <div class="font-medium text-gray-900">{{ $av->auteur->name ?? 'Utilisateur' }}</div>
                                <div class="text-xs text-gray-500">{{ optional($av->created_at)->diffForHumans() }}</div>
                            </div>
                            <div class="flex items-center gap-1 text-[#facc15] mb-2">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= $av->note)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $av->commentaire }}</p>
                        </div>
                    @endforeach
                </div>

                @if($avis->count() > 6)
                    <div class="mt-4">
                        <a href="#" class="text-sm text-[#b58900] hover:text-[#8a6a00] transition">Voir tous les avis →</a>
                    </div>
                @endif
            </div>
        @endif

        {{-- Form avis --}}
        <div class="mt-10 bg-white/80 backdrop-blur-xl border aa-border rounded-3xl p-6 shadow-lg">
            <h3 class="text-xl font-semibold text-gray-900 mb-5 flex items-center gap-2">
                <i class="fa-solid fa-pen text-[#b58900]"></i> Laisser un avis
            </h3>

            @if(session('success'))
                <div class="p-3 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-3 mb-4 text-red-800 bg-red-100 border border-red-300 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            @auth
                <form action="{{ route('avis.store', $appartement->id) }}" method="POST"
                    x-data="{ rating: 0 }"
                    class="space-y-5 animate-fadeIn">
                    @csrf

                    <div class="flex items-center gap-2 justify-center md:justify-start text-3xl">
                        <template x-for="i in 5">
                            <button type="button"
                                @click="rating = i"
                                @mouseenter="rating = i"
                                @mouseleave="rating = rating"
                                :class="i <= rating ? 'text-[#facc15]' : 'text-gray-300'"
                                class="transition transform hover:scale-125">
                                <i class="fa-solid fa-star"></i>
                            </button>
                        </template>
                        <input type="hidden" name="note" :value="rating">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Votre commentaire</label>
                        <textarea name="commentaire" rows="4"
                            class="w-full border aa-border rounded-xl px-3 py-2 text-gray-700 focus:ring-2 focus:ring-[#facc15] focus:outline-none"
                            placeholder="Décrivez votre expérience avec ce logement..." required></textarea>
                    </div>

                    <div class="flex justify-center md:justify-start">
                        <button type="submit"
                            class="btn-gold px-6 py-2.5 rounded-full font-semibold hover:scale-[1.03] transition">
                            Publier mon avis
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center text-gray-600 text-sm">
                    <a href="{{ route('login') }}" class="text-[#b58900] font-semibold hover:underline">
                        Connectez-vous
                    </a> pour laisser un avis sur cet appartement.
                </div>
            @endauth
        </div>

        {{-- Similaires --}}
        @if($similaires && $similaires->count())
            <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-6 shadow-lg">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Dans le même style</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($similaires as $s)
                        @php
                            $img = optional($s->images->first())->url
                                ? asset('storage/'.optional($s->images->first())->url)
                                : 'https://via.placeholder.com/400x250?text=Appartement';
                        @endphp
                        <a href="{{ route('front.show', $s->id) }}"
                           class="group rounded-2xl overflow-hidden border aa-border hover:shadow-lg transition bg-white/70">
                            <img src="{{ $img }}"
                                 class="h-40 w-full object-cover group-hover:scale-105 transition duration-500" alt="">
                            <div class="p-3">
                                <div class="font-medium text-gray-900 truncate">{{ $s->titre }}</div>
                                <div class="text-sm text-gray-600">{{ $s->ville }} • {{ $s->chambres }} ch</div>
                                <div class="text-[#b58900] font-semibold mt-1">{{ number_format($s->prix, 0, ',', ' ') }} FCFA</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    {{-- ========= COLONNE DROITE (Sticky) ========= --}}
    <aside class="lg:col-span-1">
        <div class="sticky top-24 space-y-6">

            <div class="bg-white/80 backdrop-blur-xl border aa-border rounded-3xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-extrabold text-gray-900">{{ $price }} FCFA</div>
                        <div class="text-xs text-gray-500 -mt-0.5">par mois</div>
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- ✅ Favori sticky (AJAX) --}}
                        <form method="POST" action="{{ route('favoris.toggle', $appartement->id) }}"
                              class="favori-toggle-form">
                            @csrf
                            <button type="submit"
                                class="h-10 w-10 grid place-items-center rounded-full border aa-border hover:bg-gray-50"
                                data-appartement-id="{{ $appartement->id }}"
                                aria-label="Favori">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5 transition-all duration-300 favori-heart"
                                     fill="{{ $isFavori ? '#facc15' : 'none' }}"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                                          2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09
                                          C13.09 3.81 14.76 3 16.5 3
                                          19.58 3 22 5.42 22 8.5
                                          c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                </svg>
                            </button>
                        </form>

                        <div x-data="{open:false}" class="relative">
                            <button @click="open=!open" class="h-10 w-10 grid place-items-center rounded-full border aa-border hover:bg-gray-50" title="Partager">
                                <i class="fa-solid fa-share-nodes"></i>
                            </button>
                            <div x-show="open" @click.outside="open=false" x-transition
                                class="absolute right-0 mt-2 w-56 bg-white border aa-border rounded-xl shadow-lg p-2 z-10">
                                <a target="_blank" href="https://wa.me/?text={{ urlencode($appartement->titre.' - '.$fullUrl) }}"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50">
                                    <i class="fa-brands fa-whatsapp text-green-600"></i> WhatsApp
                                </a>
                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($fullUrl) }}"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50">
                                    <i class="fa-brands fa-facebook text-blue-600"></i> Facebook
                                </a>
                                <button
                                    x-data
                                    @click="navigator.clipboard.writeText('{{ $fullUrl }}'); $el.innerText='Lien copié !'; setTimeout(()=>{$el.innerText='Copier le lien';},1500);"
                                    class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50">
                                    <i class="fa-regular fa-copy"></i> Copier le lien
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                @auth
                    <form action="{{ route('front.message.send', $appartement->id) }}" method="POST" class="mt-4 space-y-3">
                        @csrf
                        <textarea name="contenu" rows="4" placeholder="Présentez-vous et posez vos questions…"
                            class="w-full px-3 py-2 text-sm bg-white border aa-border rounded-xl focus:ring-2 focus:ring-[#facc15] focus:outline-none"></textarea>
                        <button type="submit" class="w-full btn-gold py-2.5 rounded-full font-semibold hover:scale-[1.02] transition">
                            Contacter le bailleur
                        </button>
                    </form>
                @endauth

                @guest
                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="w-full btn-gold py-2.5 rounded-full font-semibold inline-flex items-center justify-center">
                            Se connecter pour contacter
                        </a>
                    </div>
                @endguest

                <div class="mt-6 border-t aa-border pt-4">
                    <div class="text-sm text-gray-500 mb-1">Bailleur</div>
                    <div class="font-medium text-gray-900">{{ $appartement->bailleur->nom }}</div>
                    <div class="text-sm text-gray-600">{{ $appartement->bailleur->email }}</div>
                    <div class="text-sm text-gray-600">{{ $appartement->bailleur->telephone ?? 'Téléphone non fourni' }}</div>

                    @if(Route::has('front.index'))
                        <a href="{{ route('front.index', ['q' => $appartement->bailleur->nom]) }}"
                           class="mt-3 inline-flex items-center gap-1 text-sm text-[#b58900] hover:text-[#8a6a00] transition">
                            Voir d’autres annonces de ce bailleur →
                        </a>
                    @endif
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-xl border aa-border rounded-3xl p-5 shadow">
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-shield-halved text-[#b58900]"></i> Paiements sécurisés</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-comments text-[#b58900]"></i> Messagerie interne</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-[#b58900]"></i> Annonces vérifiées</li>
                </ul>
            </div>

        </div>
    </aside>
</section>

{{-- ======================= BARRE FLOTTANTE MOBILE (CTA) ======================= --}}
<div class="fixed bottom-3 inset-x-0 z-40 px-4 md:hidden">
    <div class="mx-auto max-w-md rounded-2xl shadow-lg border aa-border bg-white/90 backdrop-blur-xl p-3 flex items-center justify-between">
        <div>
            <div class="text-base font-extrabold text-gray-900">{{ $price }} FCFA</div>
            <div class="text-[11px] text-gray-500 -mt-0.5">par mois</div>
        </div>
        @auth
            <a href="#contact-bailleur-mobile"
               onclick="window.scrollTo({top: document.querySelector('textarea[name=contenu]').getBoundingClientRect().top + window.scrollY - 140, behavior:'smooth'})"
               class="btn-gold px-4 py-2 rounded-full text-sm font-semibold">
                Contacter
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-gold px-4 py-2 rounded-full text-sm font-semibold">Contacter</a>
        @endauth
    </div>
</div>

{{-- ======================= RETOUR ======================= --}}
<div class="aa-container mx-auto px-4 sm:px-6 mt-16 mb-10 text-center">
    <a href="{{ route('front.index') }}"
       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full border border-[#facc15]/40 bg-white/80 backdrop-blur-md text-gray-700 font-medium text-sm shadow-md hover:shadow-lg hover:bg-[#fff8db] hover:text-[#b58900] transition-all duration-300 group">
        <i class="fa-solid fa-arrow-left text-[#b58900] group-hover:-translate-x-1 transition-transform duration-300"></i>
        <span class="tracking-wide">Retour au catalogue</span>
    </a>
</div>

@endsection

{{-- ======================= SEO JSON-LD ======================= --}}
@section('seo')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Apartment',
    'name' => $appartement->titre,
    'address' => $appartement->adresse . ', ' . $appartement->ville . ', Dakar',
    'numberOfRooms' => $appartement->chambres,
    'floorSize' => [
        '@type' => 'QuantitativeValue',
        'value' => $appartement->surface ?? null,
        'unitCode' => 'MTK',
    ],
    'offers' => [
        '@type' => 'Offer',
        'price' => $appartement->prix,
        'priceCurrency' => 'XOF',
        'availability' => 'https://schema.org/InStock',
    ],
    'image' => $images,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const csrf = '{{ csrf_token() }}';
    const isAuthenticated = @json(auth()->check());
    const loginUrl = "{{ route('login') }}";

    document.querySelectorAll('.favori-toggle-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!isAuthenticated) {
                window.location.href = loginUrl;
                return;
            }

            const btn = form.querySelector('button[data-appartement-id]');
            const id = btn?.dataset?.appartementId;

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    }
                });

                if (!res.ok) throw new Error();
                const data = await res.json();

                // 🔁 Sync des 2 coeurs sur la page
                document.querySelectorAll(`button[data-appartement-id="${id}"] .favori-heart`)
                    .forEach(svg => svg.setAttribute('fill', data.added ? '#facc15' : 'none'));

                showToast(data.message || (data.added ? 'Ajouté aux favoris' : 'Retiré des favoris'));
            } catch (err) {
                showToast('Une erreur est survenue.');
            }
        });
    });

    function showToast(msg) {
        const toast = document.createElement('div');
        toast.textContent = msg;
        toast.className = `
            fixed bottom-6 right-6 bg-[#facc15] text-[#1C1C1C]
            px-5 py-3 rounded-xl shadow-lg font-semibold text-sm z-50
            transition-all duration-500
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => toast.remove(), 400);
        }, 2000);
    }
});
</script>
@endpush
