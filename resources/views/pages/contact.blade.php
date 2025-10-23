{{-- resources/views/pages/contact.blade.php --}}
@extends('layouts.front')

@section('title', 'Contactez-nous — AlloAppart')
@section('meta_description', "Contactez AlloAppart pour toute question, suggestion ou réclamation. Nous sommes à votre écoute à Dakar et dans toute la région.")

@section('content')
<section class="aa-container mx-auto px-6 py-20">
    {{-- 🧭 En-tête de section --}}
    <div class="text-center mb-16 animate-fade-in">
        <h1 class="text-4xl font-extrabold text-[#1C1C1C] mb-3 tracking-tight">
            Contactez <span class="text-[#b58900]">AlloAppart</span>
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
            Vous avez une question, une suggestion ou souhaitez signaler un problème ?  
            Notre équipe vous répond sous <span class="text-[#b58900] font-medium">48 heures ouvrables</span>.
        </p>
        <div class="mx-auto mt-6 w-28 h-[3px] bg-gradient-to-r from-[#facc15] to-[#b58900] rounded-full animate-pulse"></div>
    </div>

    {{-- 💬 Formulaire de contact --}}
    <div class="grid md:grid-cols-2 gap-10 items-start">
        {{-- Formulaire --}}
        <form method="POST" action="{{ route('contact.send') }}"
              class="bg-white/90 backdrop-blur-xl shadow-xl rounded-3xl p-8 border border-gray-200 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1">
            @csrf
            <div class="grid gap-5">
                <div class="animate-slide-up delay-[100ms]">
                    <label class="block text-gray-700 font-medium mb-2">Nom complet</label>
                    <input type="text" name="nom" required
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-[#facc15] outline-none transition duration-300"
                           placeholder="Ex : Malick Niang">
                </div>

                <div class="animate-slide-up delay-[200ms]">
                    <label class="block text-gray-700 font-medium mb-2">Adresse e-mail</label>
                    <input type="email" name="email" required
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-[#facc15] outline-none transition duration-300"
                           placeholder="Ex : malick@example.com">
                </div>

                <div class="animate-slide-up delay-[300ms]">
                    <label class="block text-gray-700 font-medium mb-2">Objet du message</label>
                    <input type="text" name="sujet"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-[#facc15] outline-none transition duration-300"
                           placeholder="Ex : Demande d’assistance ou signalement">
                </div>

                <div class="animate-slide-up delay-[400ms]">
                    <label class="block text-gray-700 font-medium mb-2">Message</label>
                    <textarea name="message" rows="5" required
                              class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-[#facc15] outline-none transition duration-300 resize-none"
                              placeholder="Expliquez brièvement votre demande..."></textarea>
                </div>

                <button type="submit"
                        class="mt-4 w-full bg-gradient-to-r from-[#facc15] to-[#b58900] text-[#1C1C1C] font-semibold py-3 rounded-full shadow-md hover:shadow-2xl transition duration-300 hover:scale-[1.02]">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Envoyer le message
                </button>
            </div>
        </form>

        {{-- Infos de contact --}}
        <div class="flex flex-col justify-center space-y-8 text-gray-700 animate-fade-in">
            <div class="hover:bg-white/70 p-4 rounded-xl transition">
                <h3 class="text-lg font-semibold text-[#b58900] mb-2">📍 Adresse</h3>
                <p>AlloAppart Sénégal<br><span class="font-medium">Plateau, Dakar — Sénégal</span></p>
            </div>

            <div class="hover:bg-white/70 p-4 rounded-xl transition">
                <h3 class="text-lg font-semibold text-[#b58900] mb-2">📞 Téléphone</h3>
                <p class="leading-relaxed">
                    <a href="tel:+221772298684" class="hover:text-[#b58900]">+221 77 229 86 84</a><br>
                    <a href="tel:+221765489019" class="hover:text-[#b58900]">+221 76 548 90 19</a>
                </p>
            </div>

            <div class="hover:bg-white/70 p-4 rounded-xl transition">
                <h3 class="text-lg font-semibold text-[#b58900] mb-2">📧 Email</h3>
                <p><a href="mailto:contact@alloappart.sn" class="hover:text-[#b58900]">contact@alloappart.sn</a></p>
            </div>

            <div class="hover:bg-white/70 p-4 rounded-xl transition">
                <h3 class="text-lg font-semibold text-[#b58900] mb-2">🕒 Horaires</h3>
                <p>Lundi – Vendredi : 9h00 → 18h30<br>Samedi : 10h00 → 16h00</p>
            </div>
        </div>
    </div>

    {{-- 🔙 Bouton retour à l’accueil --}}
    <div class="text-center mt-20 animate-fade-in">
        <a href="{{ route('front.index') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-[#b58900] hover:bg-[#facc15] text-white font-semibold rounded-full shadow-lg transition duration-300 hover:scale-105">
            <i class="fa-solid fa-arrow-left"></i> Retour à l’accueil
        </a>
    </div>
</section>

{{-- 🌟 Animations simples Tailwind (à ajouter dans app.css si besoin) --}}
<style>
@keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fade-in 0.8s ease-out both; }

@keyframes slide-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slide-up 0.6s ease-out both; }
</style>
@endsection
