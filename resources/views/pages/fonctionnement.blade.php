{{-- resources/views/pages/fonctionnement.blade.php --}}
@extends('layouts.front')

@section('title', 'Fonctionnement du site — AlloAppart')
@section('meta_description', "Découvrez comment fonctionne la plateforme AlloAppart : vérification des annonces, mise en relation sécurisée, et transparence dans la location immobilière à Dakar.")

@section('content')
<section class="aa-container mx-auto px-6 py-20 text-gray-700 leading-relaxed">

    {{-- 🧭 En-tête --}}
    <div class="text-center mb-16 animate-fade-in">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#1C1C1C] mb-4 tracking-tight">
            Fonctionnement du <span class="text-[#b58900]">site</span>
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
            AlloAppart est une plateforme digitale sécurisée qui simplifie la recherche, la publication et la gestion des logements à Dakar.  
            Notre objectif : <strong>connecter bailleurs et locataires de manière transparente, légale et fiable</strong>.
        </p>
        <div class="mx-auto mt-6 w-24 h-[3px] bg-gradient-to-r from-[#facc15] to-[#b58900] rounded-full animate-pulse"></div>
    </div>

    {{-- ⚙️ Contenu principal --}}
    <div class="space-y-12">

        @php
            $sections = [
                [
                    'titre' => '1. Présentation générale',
                    'icone' => 'fa-solid fa-building',
                    'texte' => "AlloAppart est une plateforme de mise en relation immobilière dédiée à la région de Dakar et ses environs. 
                    Elle permet aux propriétaires, agences et locataires de publier, rechercher et consulter des annonces immobilières en temps réel."
                ],
                [
                    'titre' => '2. Vérification des annonces',
                    'icone' => 'fa-solid fa-shield-check',
                    'texte' => "Chaque annonce est soumise à une <strong>vérification rigoureuse</strong> par nos équipes afin de garantir :",
                    'liste' => [
                        'La conformité de l’annonce avec la réalité du logement ;',
                        'L’authenticité des informations fournies (photos, prix, localisation) ;',
                        'Le respect de la législation en vigueur au Sénégal.'
                    ]
                ],
                [
                    'titre' => '3. Inscription et gestion de compte',
                    'icone' => 'fa-solid fa-user-lock',
                    'texte' => "L’inscription sur AlloAppart est <strong>gratuite</strong>. Chaque utilisateur dispose d’un <strong>espace personnel sécurisé</strong> pour :",
                    'liste' => [
                        'Publier et gérer ses annonces immobilières ;',
                        'Échanger directement avec les locataires ou bailleurs ;',
                        'Mettre à jour ses informations et suivre ses activités.'
                    ]
                ],
                [
                    'titre' => '4. Publication des annonces',
                    'icone' => 'fa-solid fa-pen-to-square',
                    'texte' => "Pour publier une annonce, le bailleur remplit un formulaire détaillé précisant :",
                    'liste' => [
                        'Le type de logement (studio, appartement, villa, etc.) ;',
                        'Le prix de location ;',
                        'La localisation précise ;',
                        'Les caractéristiques (chambres, équipements, photos).'
                    ]
                ],
                [
                    'titre' => '5. Messagerie et contact sécurisé',
                    'icone' => 'fa-solid fa-comments',
                    'texte' => "Pour protéger la vie privée, AlloAppart met en place une messagerie interne sécurisée. 
                    Les échanges entre bailleurs et locataires restent confidentiels jusqu’à la mise en relation finale."
                ],
                [
                    'titre' => '6. Gestion des avis et évaluations',
                    'icone' => 'fa-solid fa-star-half-stroke',
                    'texte' => "Après chaque expérience, les utilisateurs peuvent laisser un <strong>avis authentifié</strong>. 
                    Les avis sont modérés afin de garantir un climat de confiance et d’éviter tout abus."
                ],
                [
                    'titre' => '7. Sécurité et conformité légale',
                    'icone' => 'fa-solid fa-scale-balanced',
                    'texte' => "AlloAppart respecte les normes de la <strong>Commission de Protection des Données Personnelles (CDP)</strong> 
                    et les textes du <strong>Code des obligations civiles et commerciales</strong> du Sénégal.  
                    Toutes les données sont <strong>chiffrées et protégées</strong> dans des serveurs conformes à la législation locale."
                ],
                [
                    'titre' => '8. Engagement de qualité',
                    'icone' => 'fa-solid fa-handshake-angle',
                    'texte' => "Notre ambition : rendre la recherche immobilière <strong>plus fluide, plus transparente et plus humaine</strong>.  
                    La satisfaction et la sécurité de nos utilisateurs sont au cœur de notre mission."
                ]
            ];
        @endphp

        @foreach ($sections as $index => $section)
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl border border-gray-200 p-6 shadow-md hover:shadow-xl transition-all duration-500 animate-slide-up"
                 style="animation-delay: {{ $index * 0.1 }}s">
                <div class="flex items-start gap-4">
                    <div class="text-[#facc15] text-2xl mt-1">
                        <i class="{{ $section['icone'] }}"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-[#b58900] mb-2">{{ $section['titre'] }}</h2>
                        <p>{!! $section['texte'] !!}</p>
                        @if (!empty($section['liste']))
                            <ul class="list-disc pl-6 mt-3 space-y-1">
                                @foreach ($section['liste'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
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

{{-- 🌟 Animations --}}
<style>
@keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fade-in 0.8s ease-out both; }

@keyframes slide-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slide-up 0.7s ease-out both; }
</style>
@endsection
