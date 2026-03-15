{{-- resources/views/pages/apropos.blade.php --}}
@extends('layouts.front')

@section('title', 'À propos — AlloAppart Sénégal')
@section('meta_description', "Découvrez l’histoire, la mission et les valeurs d’AlloAppart, la première plateforme digitale de location fiable et transparente au Sénégal.")

@section('content')
<section class="aa-container mx-auto px-6 py-20 text-gray-700 leading-relaxed">

    {{-- 🧭 En-tête --}}
    <div class="text-center mb-16 animate-fade-in">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#1C1C1C] mb-4 tracking-tight">
            À propos de <span class="text-[#b58900]">AlloAppart</span>
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
            AlloAppart est une plateforme sénégalaise dédiée à la location immobilière.
            Notre mission : <strong>connecter bailleurs et locataires</strong> en toute sécurité et simplicité,
            tout en valorisant le patrimoine immobilier local.
        </p>
        <div class="mx-auto mt-6 w-28 h-[3px] bg-gradient-to-r from-[#facc15] to-[#b58900] rounded-full animate-pulse"></div>
    </div>

    {{-- 🌍 Histoire --}}
    <div class="block-section animate-slide-up delay-[100ms]">
        <h2 class="section-title"><i class="fa-solid fa-timeline text-[#facc15]"></i> 1. Notre histoire</h2>
        <p>
            L’idée d’<strong>AlloAppart</strong> est née à Dakar, d’un constat simple : trouver un logement fiable est souvent un parcours du combattant.
            Entre annonces trompeuses, arnaques et multiples intermédiaires, les locataires manquent de repères.
        </p>
        <p class="mt-2">
            En 2024, une équipe jeune et passionnée issue du <strong>Génie Logiciel</strong> et de l’immobilier a décidé de créer une solution moderne,
            100 % digitale, pensée pour les réalités sénégalaises : rapide, transparente et humaine.
        </p>
    </div>

    {{-- 💡 Mission --}}
    <div class="block-section animate-slide-up delay-[200ms]">
        <h2 class="section-title"><i class="fa-solid fa-bullseye text-[#facc15]"></i> 2. Notre mission</h2>
        <p>
            Simplifier la mise en relation entre bailleurs et locataires, grâce à une technologie fiable et une équipe dédiée à la qualité des annonces.
            AlloAppart n’est pas qu’un site : c’est un <strong>pont de confiance</strong> entre les acteurs du marché immobilier sénégalais.
        </p>
        <ul class="list-disc pl-6 mt-3 space-y-1">
            <li>Assurer la transparence dans les publications ;</li>
            <li>Garantir la sécurité des utilisateurs et de leurs données ;</li>
            <li>Favoriser la digitalisation de l’immobilier au Sénégal ;</li>
            <li>Valoriser les initiatives locales et l’économie numérique.</li>
        </ul>
    </div>

    {{-- ⚙️ Alliance humain + technologie --}}
    <div class="block-section animate-slide-up delay-[300ms]">
        <h2 class="section-title"><i class="fa-solid fa-robot text-[#facc15]"></i> 3. Une alliance entre humain et technologie</h2>
        <p>
            AlloAppart combine la précision d’une <strong>technologie moderne</strong> (intelligence artificielle, filtres intelligents, interface fluide)
            avec une <strong>présence humaine</strong> : chaque annonce est contrôlée par une équipe locale avant validation.
        </p>
        <p class="mt-2">
            Ce modèle hybride garantit une expérience sûre, agréable et conforme aux normes du marché immobilier sénégalais.
        </p>
    </div>

    {{-- ❤️ Valeurs --}}
    <div class="block-section animate-slide-up delay-[400ms]">
        <h2 class="section-title"><i class="fa-solid fa-heart text-[#facc15]"></i> 4. Nos valeurs</h2>
        <div class="grid md:grid-cols-3 gap-6 mt-5">
            <div class="value-card">
                <h3 class="font-semibold text-[#b58900] mb-2">
                    <i class="fa-solid fa-eye text-[#facc15] mr-2"></i>Transparence
                </h3>
                <p>Nous garantissons une information claire et vérifiée pour chaque annonce publiée sur la plateforme.</p>
            </div>
            <div class="value-card">
                <h3 class="font-semibold text-[#b58900] mb-2">
                    <i class="fa-solid fa-handshake text-[#facc15] mr-2"></i>Confiance
                </h3>
                <p>Chaque interaction entre bailleur et locataire est encadrée pour protéger les deux parties.</p>
            </div>
            <div class="value-card">
                <h3 class="font-semibold text-[#b58900] mb-2">
                    <i class="fa-solid fa-lightbulb text-[#facc15] mr-2"></i>Innovation
                </h3>
                <p>Nous intégrons les dernières technologies du numérique pour fluidifier les recherches et simplifier la gestion des logements.</p>
            </div>
        </div>
    </div>

    {{-- 👥 Équipe --}}
    <div class="block-section animate-slide-up delay-[500ms]">
        <h2 class="section-title"><i class="fa-solid fa-users text-[#facc15]"></i> 5. L’équipe AlloAppart</h2>
        <p>
            Derrière AlloAppart se cache une équipe de jeunes ingénieurs, designers et experts du numérique, tous animés par une même ambition :
            <strong>moderniser le marché immobilier sénégalais</strong>.
        </p>
        <p class="mt-2">
            Nous collaborons également avec des partenaires locaux (agences, promoteurs, propriétaires indépendants)
            afin de garantir la fiabilité du contenu publié.
        </p>
    </div>

    {{-- 📩 Contact --}}
    <div class="block-section animate-slide-up delay-[600ms]">
        <h2 class="section-title"><i class="fa-solid fa-envelope text-[#facc15]"></i> 6. Nous contacter</h2>
        <p>
            Une question ? Une suggestion ?  
            Écrivez-nous à <a href="mailto:contact@alloappart.sn" class="text-[#b58900] hover:underline">contact@alloappart.sn</a>  
            ou rejoignez-nous sur nos réseaux sociaux pour suivre les nouveautés.
        </p>
    </div>

    {{-- 🔙 Bouton retour à l’accueil --}}
    <div class="text-center mt-20 animate-fade-in">
        <a href="{{ route('front.index') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-[#b58900] hover:bg-[#facc15] text-white font-semibold rounded-full shadow-lg transition duration-300 hover:scale-105">
            <i class="fa-solid fa-arrow-left"></i> Retour à l’accueil
        </a>
    </div>

    {{-- 🕊️ Signature --}}
    <div class="text-center mt-16 text-gray-600 text-sm animate-fade-in">
        <p>Dernière mise à jour : {{ date('d/m/Y') }}</p>
        <p>© {{ date('Y') }} AlloAppart Sénégal — Tous droits réservés.</p>
    </div>
</section>

{{-- 🌟 Styles & animations locales --}}
<style>
.block-section {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid #e5e7eb;
    border-radius: 1.25rem;
    padding: 1.75rem;
    margin-bottom: 2.5rem;
    box-shadow: 0 6px 20px -8px rgba(0, 0, 0, 0.1);
    transition: all .4s ease;
}
.block-section:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px -10px rgba(245, 191, 0, 0.25);
}
.section-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #b58900;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: .6rem;
}
.value-card {
    background: white;
    border: 1px solid #eee;
    border-radius: 1rem;
    padding: 1.25rem;
    box-shadow: 0 6px 16px -8px rgba(0, 0, 0, 0.1);
    transition: all .3s ease;
}
.value-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px -10px rgba(245, 191, 0, 0.25);
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
