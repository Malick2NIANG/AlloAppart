{{-- resources/views/front/favoris.blade.php --}}
@extends('layouts.front')

@section('title', 'Mes Favoris — AlloAppart')
@section('meta_description', 'Découvrez tous les appartements que vous avez ajoutés à vos favoris sur AlloAppart.')

@section('content')
<section class="aa-container mx-auto px-4 sm:px-6 py-20">

    {{-- 🧭 Titre principal --}}
    <div class="text-center mb-14 animate-fadeIn">
        <h1 class="text-3xl md:text-4xl font-bold text-[#1C1C1C] mb-2">
            ❤️ Vos appartements favoris
        </h1>
        <p class="text-gray-600 text-base">
            Retrouvez ici tous les logements que vous avez enregistrés pour les consulter plus tard.
        </p>
        <div class="w-20 h-[3px] bg-[#facc15] mx-auto mt-4 rounded-full"></div>
    </div>

    {{-- 🏘️ Liste des appartements favoris --}}
    @if ($favoris->count() > 0)
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 animate-fadeIn">
            @foreach ($favoris as $app)
                @php
                    $firstImage = optional($app->images->first())->url;
                    $imgUrl = $firstImage ? asset('storage/'.$firstImage) : 'https://via.placeholder.com/400x250?text=Appartement';
                @endphp

                <div class="group relative bg-white/70 backdrop-blur-xl border border-[#f5e8b6]/30 rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-[1.01]">

                    {{-- 🏙️ Image principale --}}
                    <div class="relative overflow-hidden">
                        <a href="{{ route('front.show', $app->id) }}">
                            <img src="{{ $imgUrl }}" alt="{{ $app->titre }}"
                                class="h-56 w-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out rounded-t-2xl">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-50"></div>
                        </a>

                        {{-- ❤️ Bouton pour retirer du favori --}}
                        <form action="{{ route('favoris.toggle', $app->id) }}" method="POST"
                              class="absolute top-3 right-3">
                            @csrf
                            <button type="submit"
                                    class="bg-[#facc15]/90 hover:bg-[#b58900]/90 text-white rounded-full p-2 shadow-md transition"
                                    aria-label="Retirer des favoris"
                                    title="Retirer des favoris">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
                                             2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09
                                             C13.09 3.81 14.76 3 16.5 3
                                             19.58 3 22 5.42 22 8.5
                                             c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#b58900]" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 8-9 13-9 13S3 18 3 10a9 9 0 1 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            {{ $app->ville }} • {{ $app->chambres }} ch • {{ $app->surface ?? '—' }} m²
                        </p>

                        <p class="font-semibold text-[#b58900] text-sm md:text-base">
                            {{ number_format($app->prix, 0, ',', ' ') }} FCFA / mois
                        </p>

                        <div class="mt-3">
                            <a href="{{ route('front.show', $app->id) }}"
                               class="inline-flex items-center gap-1 text-xs text-[#b58900]/80 group-hover:text-[#b58900] transition-colors duration-300">
                                Voir plus
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        {{-- 😔 Aucun favori --}}
        <div class="text-center py-24">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-6 h-16 w-16 text-gray-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
                         2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09
                         C13.09 3.81 14.76 3 16.5 3
                         19.58 3 22 5.42 22 8.5
                         c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Aucun favori pour le moment</h2>
            <p class="text-gray-500 mb-6">Ajoutez des appartements à vos favoris pour les retrouver facilement ici.</p>
            <a href="{{ route('front.index') }}"
               class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#facc15] text-[#1C1C1C] font-medium rounded-full shadow-md hover:scale-105 transition">
                <i class="fa-solid fa-arrow-left"></i> Retourner à l’accueil
            </a>
        </div>
    @endif

</section>

{{-- ✨ Animation légère --}}
<style>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
  animation: fadeIn 0.6s ease-out;
}
</style>
@endsection
