{{-- resources/views/pages/conditions.blade.php --}}
@extends('layouts.front')

@section('title', 'Conditions Générales d’Utilisation — AlloAppart')
@section('meta_description', "Consultez les conditions générales d’utilisation d’AlloAppart, conformes à la réglementation sénégalaise en matière de services numériques et de protection des utilisateurs.")

@section('content')
<section class="aa-container mx-auto px-6 py-20 text-gray-700 leading-relaxed">

    {{-- 🧭 En-tête --}}
    <div class="text-center mb-16 animate-fade-in">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#1C1C1C] mb-4 tracking-tight">
            Conditions Générales <span class="text-[#b58900]">d’Utilisation</span>
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
            En accédant à la plateforme <strong>AlloAppart</strong>, vous acceptez sans réserve les présentes conditions,
            établies conformément aux lois de la République du Sénégal.
        </p>
        <div class="mx-auto mt-6 w-28 h-[3px] bg-gradient-to-r from-[#facc15] to-[#b58900] rounded-full animate-pulse"></div>
    </div>

    {{-- 📘 Contenu principal --}}
    <div class="space-y-10">
        @php
            $sections = [
                [
                    'titre' => '1. Objet',
                    'icone' => 'fa-solid fa-scroll',
                    'texte' => 'Les présentes Conditions Générales d’Utilisation (CGU) définissent les règles d’accès, d’inscription et d’utilisation de la plateforme 
                    <strong>AlloAppart</strong>, accessible à l’adresse 
                    <a href="' . route('front.index') . '" class="text-[#b58900] hover:underline">www.alloappart.sn</a>.
                    Ce site permet la mise en relation entre bailleurs, agences immobilières et locataires potentiels.'
                ],
                [
                    'titre' => '2. Acceptation des conditions',
                    'icone' => 'fa-solid fa-circle-check',
                    'texte' => 'En accédant à AlloAppart, tout utilisateur reconnaît avoir lu, compris et accepté les présentes CGU. 
                    Si vous n’acceptez pas ces conditions, vous devez cesser d’utiliser le site.'
                ],
                [
                    'titre' => '3. Inscription et compte utilisateur',
                    'icone' => 'fa-solid fa-user-lock',
                    'texte' => 'L’accès à certaines fonctionnalités (publication d’annonces, messagerie, favoris, etc.) nécessite la création d’un compte personnel. 
                    L’utilisateur s’engage à fournir des informations exactes, à jour et complètes lors de son inscription.
                    <br><br>Le compte est personnel et non transférable. Toute utilisation frauduleuse pourra entraîner sa suspension ou suppression.'
                ],
                [
                    'titre' => '4. Services proposés',
                    'icone' => 'fa-solid fa-building',
                    'texte' => 'AlloAppart permet :',
                    'liste' => [
                        'La recherche de logements à louer à Dakar et dans les environs ;',
                        'La publication d’annonces de location par les bailleurs ;',
                        'La mise en contact entre utilisateurs via une messagerie sécurisée ;',
                        'La consultation d’avis et de retours d’expérience d’autres utilisateurs.'
                    ]
                ],
                [
                    'titre' => '5. Responsabilité des utilisateurs',
                    'icone' => 'fa-solid fa-scale-unbalanced-flip',
                    'texte' => 'Les utilisateurs s’engagent à :',
                    'liste' => [
                        'Ne pas publier d’informations fausses, trompeuses ou diffamatoires ;',
                        'Respecter la vie privée et la dignité des autres membres ;',
                        'Utiliser la plateforme dans le respect des lois sénégalaises et de la morale publique.'
                    ]
                ],
                [
                    'titre' => '6. Responsabilité d’AlloAppart',
                    'icone' => 'fa-solid fa-shield-halved',
                    'texte' => 'AlloAppart agit comme un intermédiaire technique. 
                    Nous ne garantissons pas la véracité ou la qualité des annonces déposées, 
                    mais effectuons des contrôles réguliers pour limiter les fraudes.
                    <br><br>AlloAppart ne saurait être tenu responsable des transactions ou litiges entre utilisateurs, sauf en cas de faute avérée de notre part.'
                ],
                [
                    'titre' => '7. Propriété intellectuelle',
                    'icone' => 'fa-solid fa-copyright',
                    'texte' => 'L’ensemble du contenu du site (textes, logos, photos, design, code) est la propriété exclusive d’AlloAppart.
                    Toute reproduction, modification ou diffusion non autorisée est strictement interdite.'
                ],
                [
                    'titre' => '8. Données personnelles',
                    'icone' => 'fa-solid fa-lock',
                    'texte' => 'Les données collectées sont traitées conformément à la <strong>loi n° 2008-12</strong> relative à la protection des données personnelles. 
                    Pour plus d’informations, consultez notre 
                    <a href="' . route('confidentialite') . '" class="text-[#b58900] hover:underline">Politique de Confidentialité</a>.'
                ],
                [
                    'titre' => '9. Suspension et résiliation',
                    'icone' => 'fa-solid fa-ban',
                    'texte' => 'AlloAppart se réserve le droit de suspendre ou supprimer un compte utilisateur en cas de non-respect des présentes conditions
                    ou de comportement jugé inapproprié, sans préavis ni indemnité.'
                ],
                [
                    'titre' => '10. Droit applicable et juridiction',
                    'icone' => 'fa-solid fa-gavel',
                    'texte' => 'Les présentes CGU sont régies par le <strong>droit sénégalais</strong>. 
                    En cas de litige, compétence exclusive est attribuée aux tribunaux de <strong>Dakar</strong>.'
                ],
                [
                    'titre' => '11. Contact',
                    'icone' => 'fa-solid fa-envelope-open-text',
                    'texte' => 'Pour toute question relative à ces conditions, vous pouvez nous écrire à :
                    <a href="mailto:contact@alloappart.sn" class="text-[#b58900] hover:underline">contact@alloappart.sn</a>.'
                ]
            ];
        @endphp

        {{-- 💼 Boucle de sections stylisées --}}
        @foreach ($sections as $index => $section)
        <div class="block-section animate-slide-up" style="animation-delay: {{ $index * 0.1 }}s">
            <h2 class="section-title">
                <i class="{{ $section['icone'] }} text-[#facc15]"></i> {{ $section['titre'] }}
            </h2>
            <p>{!! $section['texte'] !!}</p>
            @if (!empty($section['liste']))
                <ul class="list-disc pl-6 mt-2 space-y-1">
                    @foreach ($section['liste'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        @endforeach
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
    box-shadow: 0 6px 20px -8px rgba(0, 0, 0, 0.1);
    transition: all .4s ease;
}
.block-section:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px -10px rgba(245, 191, 0, 0.25);
}
.section-title {
    font-size: 1.15rem;
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
