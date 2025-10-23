{{-- resources/views/front/partials/appartements.blade.php --}}
<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

    @forelse($appartements as $app)
        @php
            $firstImage = optional($app->images->first())->url;
            $imgUrl = $firstImage ? asset('storage/'.$firstImage) : 'https://via.placeholder.com/400x250?text=Appartement';
            $isFavori = auth()->check() ? auth()->user()->favoris->contains($app->id) : false;
        @endphp

        <a href="{{ route('front.show', $app->id) }}"
           class="group relative bg-white/70 backdrop-blur-xl border border-[#f5e8b6]/30 rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-[1.01]">

            {{-- 🏙️ Image principale --}}
            <div class="relative overflow-hidden">
                <img src="{{ $imgUrl }}"
                     alt="{{ $app->titre }}"
                     class="h-56 w-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out rounded-t-2xl">
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-50"></div>

                {{-- ❤️ Bouton favori (même visuel, mais fonctionnel) --}}
                <form method="POST"
                      action="{{ route('favoris.toggle', $app->id) }}"
                      class="absolute top-3 right-3"
                      onsubmit="return handleFavori(event)">
                    @csrf
                    <button type="submit"
                            class="bg-white/80 hover:bg-[#facc15]/90 text-gray-800 hover:text-black rounded-full p-2 shadow-md transition"
                            aria-label="Ajouter aux favoris">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4 {{ $isFavori ? 'fill-[#b58900] stroke-[#b58900]' : '' }}"
                             fill="{{ $isFavori ? '#b58900' : 'none' }}"
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
            </div>

            {{-- 🏠 Détails du logement --}}
            <div class="p-4">
                <h3 class="font-semibold text-lg text-gray-900 mb-1 truncate group-hover:text-[#b58900] transition-colors duration-300">
                    {{ $app->titre }}
                </h3>

                <p class="text-sm text-gray-600 mb-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#b58900]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 8-9 13-9 13S3 18 3 10a9 9 0 1 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $app->ville }} • {{ $app->chambres }} ch • {{ $app->surface ?? '—' }} m²
                </p>

                <p class="font-semibold text-[#b58900] text-sm md:text-base">
                    {{ number_format($app->prix, 0, ',', ' ') }} FCFA / mois
                </p>

                {{-- 💡 Lien "Voir plus" animé --}}
                <div class="mt-3">
                    <span class="inline-flex items-center gap-1 text-xs text-[#b58900]/80 group-hover:text-[#b58900] transition-colors duration-300">
                        Voir plus
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-4 text-center text-gray-500 py-20">
            <p class="text-base md:text-lg font-medium mb-2">😔 Aucun appartement disponible</p>
            <p class="text-sm text-gray-400">Essayez de modifier vos filtres ou revenez plus tard.</p>
        </div>
    @endforelse
</div>

{{-- 🔢 Pagination --}}
@if ($appartements->hasPages())
    <div class="mt-12 flex justify-center">
        {{ $appartements->links() }}
    </div>
@endif

{{-- 🔐 Script de redirection vers login si non connecté --}}
<script>
function handleFavori(event) {
    const isAuthenticated = @json(auth()->check());
    if (!isAuthenticated) {
        event.preventDefault();
        window.location.href = "{{ route('login') }}";
        return false;
    }
    return true;
}
</script>
