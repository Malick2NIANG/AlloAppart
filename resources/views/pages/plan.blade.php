{{-- resources/views/pages/plan.blade.php --}}
@extends('layouts.front')

@section('title', 'Plan du site — AlloAppart')
@section('meta_description', "Accédez facilement à toutes les pages d’AlloAppart Sénégal : accueil, annonces, contact, politique de confidentialité, conditions et plus encore.")

@section('content')
<section class="aa-container mx-auto px-6 py-20 text-gray-700 leading-relaxed">

    {{-- 🧭 En-tête --}}
    <div class="text-center mb-16 animate-fade-in">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#1C1C1C] mb-4 tracking-tight">
            Plan du <span class="text-[#b58900]">site</span>
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
            Retrouvez ici l’ensemble des pages et fonctionnalités principales d’<strong>AlloAppart</strong>, 
            classées pour une navigation rapide, claire et intuitive.
        </p>
        <div class="mx-auto mt-6 w-24 h-[3px] bg-gradient-to-r from-[#facc15] to-[#b58900] rounded-full animate-pulse"></div>
    </div>

    {{-- 🗂️ Contenu du plan --}}
    <div class="grid md:grid-cols-3 gap-10">

        {{-- 🏠 Section Accueil & Annonces --}}
        <div class="card-plan animate-slide-up delay-[100ms]">
            <h2 class="title-plan">
                <i class="fa-solid fa-home text-[#facc15]"></i> Accueil & Annonces
            </h2>
            <ul class="list-plan">
                <li><a href="{{ route('front.index') }}" class="link-plan">🏡 Accueil</a></li>
                <li><a href="{{ route('front.index') }}?q=Dakar" class="link-plan">📍 Appartements à Dakar</a></li>
                <li><a href="{{ route('front.index') }}?min=0&max=250000" class="link-plan">💰 Logements ≤ 250 000 FCFA</a></li>
                <li><a href="{{ route('dashboard') }}" class="link-plan">👤 Mon espace</a></li>
            </ul>
        </div>

        {{-- 📚 Section Informations & Pages légales --}}
        <div class="card-plan animate-slide-up delay-[200ms]">
            <h2 class="title-plan">
                <i class="fa-solid fa-scale-balanced text-[#facc15]"></i> Informations légales
            </h2>
            <ul class="list-plan">
                <li><a href="{{ route('conditions') }}" class="link-plan">📜 Conditions d’utilisation</a></li>
                <li><a href="{{ route('confidentialite') }}" class="link-plan">🔒 Politique de confidentialité</a></li>
                <li><a href="{{ route('fonctionnement') }}" class="link-plan">⚙️ Fonctionnement du site</a></li>
                <li><a href="{{ route('apropos') }}" class="link-plan">🏢 À propos d’AlloAppart</a></li>
                <li><a href="{{ route('plan') }}" class="link-plan">🗺️ Plan du site</a></li>
            </ul>
        </div>

        {{-- ✉️ Section Support & Réseaux --}}
        <div class="card-plan animate-slide-up delay-[300ms]">
            <h2 class="title-plan">
                <i class="fa-solid fa-envelope text-[#facc15]"></i> Support & Réseaux
            </h2>
            <ul class="list-plan">
                <li><a href="{{ route('contact') }}" class="link-plan">📩 Nous contacter</a></li>
                <li><a href="mailto:contact@alloappart.sn" class="link-plan">📧 contact@alloappart.sn</a></li>
                <li><a href="{{ route('social.twitter') }}" target="_blank" rel="noopener" class="link-plan">🐦 Twitter / X</a></li>
                <li><a href="{{ route('social.instagram') }}" target="_blank" rel="noopener" class="link-plan">📸 Instagram</a></li>
                <li><a href="{{ route('social.facebook') }}" target="_blank" rel="noopener" class="link-plan">📘 Facebook</a></li>
                <li><a href="{{ route('social.tiktok') }}" target="_blank" rel="noopener" class="link-plan">🎵 TikTok</a></li>
            </ul>
        </div>
    </div>

    {{-- 🔙 Bouton retour à l’accueil --}}
    <div class="text-center mt-20 animate-fade-in">
        <a href="{{ route('front.index') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-[#b58900] hover:bg-[#facc15] text-white font-semibold rounded-full shadow-lg transition duration-300 hover:scale-105">
            <i class="fa-solid fa-arrow-left"></i> Retour à l’accueil
        </a>
    </div>

    {{-- 🕊️ Bas de page --}}
    <div class="text-center mt-16 text-gray-600 text-sm animate-fade-in">
        <p>Dernière mise à jour : {{ date('d/m/Y') }}</p>
        <p>© {{ date('Y') }} AlloAppart Sénégal — Tous droits réservés.</p>
    </div>
</section>

{{-- 🌟 Styles & animations locales --}}
<style>
.card-plan {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(10px);
    border: 1px solid #e5e7eb;
    border-radius: 1.25rem;
    padding: 1.75rem;
    box-shadow: 0 6px 20px -6px rgba(0, 0, 0, 0.1);
    transition: all .4s ease;
}
.card-plan:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px -10px rgba(245, 191, 0, 0.25);
}

.title-plan {
    font-size: 1.1rem;
    font-weight: 600;
    color: #b58900;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: .6rem;
}

.list-plan {
    list-style: none;
    margin: 0;
    padding: 0;
}
.link-plan {
    display: block;
    padding: .45rem 0;
    color: #444;
    text-decoration: none;
    transition: color .3s ease, transform .3s ease;
}
.link-plan:hover {
    color: #b58900;
    transform: translateX(5px);
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 0.8s ease-out both; }

@keyframes slide-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-slide-up { animation: slide-up 0.8s ease-out both; }
</style>
@endsection
