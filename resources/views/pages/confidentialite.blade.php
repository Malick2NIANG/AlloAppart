{{-- resources/views/pages/confidentialite.blade.php --}}
@extends('layouts.front')

@section('title', 'Politique de Confidentialité — AlloAppart Sénégal')
@section('meta_description', "Découvrez comment AlloAppart protège vos données personnelles, conformément à la loi sénégalaise sur la protection des données (CDP, loi n°2008-12).")

@section('content')
<section class="aa-container mx-auto px-6 py-20 text-gray-700 leading-relaxed">

    {{-- 🧭 En-tête --}}
    <div class="text-center mb-16 animate-fade-in">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#1C1C1C] mb-4 tracking-tight">
            Politique de <span class="text-[#b58900]">Confidentialité</span>
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
            Chez <strong>AlloAppart Sénégal</strong>, la confidentialité et la protection de vos données personnelles sont une priorité.
            Nous respectons scrupuleusement la <strong>loi n°2008-12</strong> relative à la protection des données à caractère personnel
            adoptée par la République du Sénégal et supervisée par la <strong>Commission de Protection des Données Personnelles (CDP)</strong>.
        </p>
        <div class="mx-auto mt-6 w-28 h-[3px] bg-gradient-to-r from-[#facc15] to-[#b58900] rounded-full animate-pulse"></div>
    </div>

    {{-- 🔐 Contenu principal --}}
    <div class="space-y-10">

        {{-- 1. Collecte des données --}}
        <div class="block-section animate-slide-up delay-[100ms]">
            <h2 class="section-title">
                <i class="fa-solid fa-database text-[#facc15]"></i> 1. Collecte des données
            </h2>
            <p>
                Nous collectons uniquement les informations nécessaires au bon fonctionnement du service, notamment :
            </p>
            <ul class="list-disc pl-6 mt-2 space-y-1">
                <li>Vos informations d’inscription (nom, email, mot de passe chiffré) ;</li>
                <li>Les données de vos annonces (type de logement, localisation, prix, photos) ;</li>
                <li>Les échanges via la messagerie interne ;</li>
                <li>Les statistiques d’usage afin d’améliorer l’expérience utilisateur.</li>
            </ul>
        </div>

        {{-- 2. Utilisation des données --}}
        <div class="block-section animate-slide-up delay-[200ms]">
            <h2 class="section-title">
                <i class="fa-solid fa-gears text-[#facc15]"></i> 2. Utilisation des données
            </h2>
            <p>
                Les données collectées sont utilisées exclusivement pour :
            </p>
            <ul class="list-disc pl-6 mt-2 space-y-1">
                <li>La gestion de votre compte et de vos annonces ;</li>
                <li>La mise en relation entre locataires et bailleurs ;</li>
                <li>L’amélioration de nos services (ergonomie, sécurité, fiabilité) ;</li>
                <li>L’envoi d’informations ou notifications liées à votre activité sur le site.</li>
            </ul>
        </div>

        {{-- 3. Conservation et sécurité --}}
        <div class="block-section animate-slide-up delay-[300ms]">
            <h2 class="section-title">
                <i class="fa-solid fa-shield-halved text-[#facc15]"></i> 3. Conservation et sécurité
            </h2>
            <p>
                Vos données sont stockées sur des serveurs sécurisés et protégées par des mesures techniques conformes aux standards internationaux.
                <br><br>
                AlloAppart applique un chiffrement des mots de passe, des sauvegardes régulières et un contrôle d’accès strict
                pour éviter toute perte, vol ou altération des informations personnelles.
            </p>
        </div>

        {{-- 4. Partage des données --}}
        <div class="block-section animate-slide-up delay-[400ms]">
            <h2 class="section-title">
                <i class="fa-solid fa-users text-[#facc15]"></i> 4. Partage des données
            </h2>
            <p>
                AlloAppart ne vend, ne loue et ne communique aucune donnée personnelle à des tiers sans votre consentement explicite.
                <br><br>
                Certaines informations peuvent être partagées uniquement avec :
            </p>
            <ul class="list-disc pl-6 mt-2 space-y-1">
                <li>Les autorités compétentes en cas d’obligation légale ;</li>
                <li>Les prestataires techniques indispensables au fonctionnement du service (hébergement, messagerie). </li>
            </ul>
        </div>

        {{-- 5. Vos droits --}}
        <div class="block-section animate-slide-up delay-[500ms]">
            <h2 class="section-title">
                <i class="fa-solid fa-user-shield text-[#facc15]"></i> 5. Vos droits
            </h2>
            <p>
                Conformément à la législation en vigueur, vous disposez des droits suivants :
            </p>
            <ul class="list-disc pl-6 mt-2 space-y-1">
                <li>Droit d’accès, de rectification et de suppression de vos données ;</li>
                <li>Droit d’opposition au traitement de vos informations personnelles ;</li>
                <li>Droit à la portabilité de vos données sur demande écrite.</li>
            </ul>
            <p class="mt-3">
                Pour exercer vos droits, contactez-nous à :
                <a href="mailto:contact@alloappart.sn" class="text-[#b58900] hover:underline">contact@alloappart.sn</a>.
            </p>
        </div>

        {{-- 6. Cookies --}}
        <div class="block-section animate-slide-up delay-[600ms]">
            <h2 class="section-title">
                <i class="fa-solid fa-cookie-bite text-[#facc15]"></i> 6. Utilisation des cookies
            </h2>
            <p>
                Notre site utilise des cookies pour :
            </p>
            <ul class="list-disc pl-6 mt-2 space-y-1">
                <li>Faciliter la navigation et mémoriser vos préférences ;</li>
                <li>Mesurer l’audience du site et analyser les performances ;</li>
                <li>Garantir une expérience utilisateur personnalisée et fluide.</li>
            </ul>
            <p class="mt-3">
                Vous pouvez à tout moment gérer vos préférences depuis votre navigateur ou consulter notre
                <a href="{{ route('cookies') }}" class="text-[#b58900] hover:underline">Politique des cookies</a>.
            </p>
        </div>

        {{-- 7. Durée de conservation --}}
        <div class="block-section animate-slide-up delay-[700ms]">
            <h2 class="section-title">
                <i class="fa-solid fa-hourglass-half text-[#facc15]"></i> 7. Durée de conservation
            </h2>
            <p>
                Les données personnelles sont conservées pendant la durée strictement nécessaire à la fourniture des services,
                ou jusqu’à suppression du compte par l’utilisateur.
            </p>
        </div>

        {{-- 8. Contact CDP --}}
        <div class="block-section animate-slide-up delay-[800ms]">
            <h2 class="section-title">
                <i class="fa-solid fa-scale-balanced text-[#facc15]"></i> 8. Contact de la CDP
            </h2>
            <p>
                En cas de litige relatif à la gestion de vos données, vous pouvez saisir la
                <strong>Commission de Protection des Données Personnelles (CDP)</strong> du Sénégal.
            </p>
            <p class="mt-2">
                <strong>Adresse :</strong> 3 Rue Calmette x Amadou Assane Ndoye, Dakar<br>
                <strong>Email :</strong> contact@cdp.sn<br>
                <strong>Site web :</strong> <a href="https://www.cdp.sn" target="_blank" class="text-[#b58900] hover:underline">www.cdp.sn</a>
            </p>
        </div>

        {{-- 🔙 Bouton retour à l’accueil --}}
        <div class="text-center mt-20 animate-fade-in">
            <a href="{{ route('front.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-[#b58900] hover:bg-[#facc15] text-white font-semibold rounded-full shadow-lg transition duration-300 hover:scale-105">
                <i class="fa-solid fa-arrow-left"></i> Retour à l’accueil
            </a>
        </div>
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
