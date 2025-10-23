{{-- resources/views/front/index.blade.php --}}
@extends('layouts.front')

@section('title', 'AlloAppart — Appartements à louer dans la région de Dakar')

{{-- ======================= SECTION HERO ======================= --}}
@section('hero')
<div class="relative hero-section overflow-hidden">
    
    {{-- 🌆 Image de fond nette + léger assombrissement --}}
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1800&q=90"
            alt="Appartements à Dakar"
            class="w-full h-full object-cover object-center scale-105 animate-[zoomIn_18s_ease-in-out_infinite_alternate]" />
        {{-- overlay sombre subtil --}}
        <div class="absolute inset-0 bg-black/55"></div>
    </div>

    {{-- 🏙️ Contenu principal clair et lisible --}}
    <div class="relative z-20 text-center py-40 md:py-52 px-6 sm:px-10 text-white">
        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 drop-shadow-[0_2px_4px_rgba(0,0,0,0.6)] animate-fadeUpSlow">
            Trouvez <span class="text-[#facc15]">votre futur logement</span><br class="hidden md:block">
            à <span class="text-white">Dakar</span>
        </h1>

        <p class="max-w-3xl mx-auto text-gray-100 text-lg md:text-xl mb-10 leading-relaxed drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)] animate-fadeUpSlow [animation-delay:300ms]">
            Des appartements, studios et villas à louer dans toute la région de Dakar —
            fiables, modernes et pensés pour votre confort.
        </p>

        {{-- 🎯 Boutons d’action --}}
        <div class="flex flex-wrap justify-center gap-4 animate-fadeUpSlow [animation-delay:500ms]">
            <a href="#appartementsContainer"
               class="bg-[#facc15] text-[#1C1C1C] px-8 py-3 rounded-full font-semibold shadow-md hover:shadow-xl hover:scale-105 transition duration-300 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass"></i> Explorer les appartements
            </a>

            <a href="{{ route('register') }}"
               class="border border-[#facc15]/60 text-white px-8 py-3 rounded-full font-semibold hover:bg-[#facc15]/10 hover:scale-105 transition duration-300 flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Publier une annonce
            </a>
        </div>

        {{-- ↓ Flèche d’invitation au scroll --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce text-[#facc15] opacity-80">
            <i class="fa-solid fa-angles-down text-2xl"></i>
        </div>
    </div>

    {{-- 📊 Statistiques nettes --}}
    <div class="relative z-10 -mt-12 pb-20">
        <div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-6 text-center px-6">
            <div class="stat-card animate-fadeUp">
                <h3 class="text-3xl font-bold text-[#facc15]" data-target="2500">0</h3>
                <p class="text-sm mt-2 text-gray-100">Appartements et studios disponibles</p>
            </div>
            <div class="stat-card animate-fadeUp [animation-delay:200ms]">
                <h3 class="text-3xl font-bold text-[#facc15]" data-target="98">0</h3>
                <p class="text-sm mt-2 text-gray-100">des utilisateurs trouvent un logement en 72 h</p>
            </div>
            <div class="stat-card animate-fadeUp [animation-delay:400ms]">
                <h3 class="text-3xl font-bold text-[#facc15]" data-target="1000">0</h3>
                <p class="text-sm mt-2 text-gray-100">bailleurs vérifiés actifs sur la plateforme</p>
            </div>
        </div>
    </div>
</div>

{{-- 🌈 Styles et animations --}}
<style>
@keyframes zoomIn {
  0% { transform: scale(1); }
  100% { transform: scale(1.08); }
}
@keyframes fadeUp {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}
.animate-fadeUp { animation: fadeUp 1s ease forwards; }
.animate-fadeUpSlow { animation: fadeUp 1.2s ease forwards; }

.stat-card {
  background: rgba(12,12,15,0.75);
  border: 1px solid rgba(250,204,21,0.25);
  border-radius: 1rem;
  padding: 1.5rem;
  box-shadow: 0 4px 15px rgba(0,0,0,0.3);
  transition: all 0.3s ease;
}
.stat-card:hover {
  background: rgba(25,25,30,0.85);
  transform: translateY(-3px);
  box-shadow: 0 0 18px rgba(250,204,21,0.25);
}

/* ✅ Anti-blur du texte sur les sections superposées */
.hero-section * {
  -webkit-font-smoothing: antialiased;
  text-rendering: optimizeLegibility;
}
</style>
@endsection

{{-- ======================= CONTENU PRINCIPAL ======================= --}}
@section('content')
<section class="aa-container mx-auto px-4 sm:px-6 py-20 bg-white">

    <div class="text-center mb-16 animate-fadeUpSlow">
        <h2 class="text-3xl md:text-4xl font-bold mb-3 text-[#1C1C1C]">Appartements récents</h2>
        <p class="text-gray-600 text-base md:text-lg">
            Explorez les dernières offres publiées par nos bailleurs partenaires dans la région de Dakar.
        </p>
        <div class="mx-auto mt-5 w-20 h-[3px] bg-[#facc15] rounded-full"></div>
    </div>

    <div id="appartementsContainer" class="animate-fadeUp">
        @include('front.partials.appartements')
    </div>
</section>

{{-- ======================= SECTION PROMO ======================= --}}
<section class="relative mt-28 animate-fadeUpSlow">
    <div class="absolute inset-0 bg-[#0f172a]"></div>
    <div class="relative text-center py-20 px-4 sm:px-6 text-white">
        <h2 class="text-4xl font-bold mb-5">Vous êtes bailleur ?</h2>
        <p class="text-gray-300 max-w-2xl mx-auto mb-8 text-lg">
            Rejoignez la communauté AlloAppart et donnez plus de visibilité à vos appartements auprès de centaines de locataires potentiels chaque jour.
        </p>
        <a href="{{ route('register') }}"
           class="btn-gold inline-flex items-center gap-3 px-8 py-3 rounded-full text-base font-semibold shadow-lg hover:scale-105 transition-transform duration-300">
            Publier une annonce maintenant
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="#1C1C1C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</section>
@endsection

{{-- ======================= SCRIPTS ======================= --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('[data-target]');
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = +el.getAttribute('data-target');
                let count = 0;
                const increment = target / 80;
                const updateCounter = () => {
                    count += increment;
                    if (count < target) {
                        el.textContent = '+' + Math.floor(count).toLocaleString();
                        requestAnimationFrame(updateCounter);
                    } else {
                        el.textContent = '+' + target.toLocaleString();
                    }
                };
                updateCounter();
                obs.unobserve(el);
            }
        });
    }, { threshold: 0.7 });

    counters.forEach(counter => observer.observe(counter));
});
</script>
@endpush
