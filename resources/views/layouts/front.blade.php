{{-- resources/views/layouts/front.blade.php --}}
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AlloAppart — Trouvez votre prochain appartement')</title>
    <meta name="description" content="@yield('meta_description', 'Catalogue d’appartements à louer à Dakar — sélection premium, design soigné, expérience fluide façon Airbnb.')">

    {{-- Favicon (tu pourras remplacer par tes icônes plus tard) --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/logo-icon.svg') }}">
    <link rel="alternate icon" href="{{ asset('brand/logo-icon-mono.svg') }}">

    {{-- Fonts (sobre & élégantes) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700,800&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
            --aa-bg:#FAFAFA;
            --aa-card:#FFFFFF;
            --aa-text:#1C1C1C;
            --aa-sub:#6B7280;      /* gray-500 */
            --aa-line:#E5E7EB;     /* gray-200 */
            --aa-accent:#D4AF37;   /* doré doux */
            --aa-accent-2:#F6E7B5; /* hover pâle */
        }
        body { background: var(--aa-bg); color: var(--aa-text); }
        .aa-container { max-width: 1200px; }
        .aa-shadow { box-shadow: 0 12px 35px -20px rgba(0,0,0,.25); }
        .aa-glass { background: rgba(255,255,255,.7); backdrop-filter: blur(10px); }
        .aa-btn {
            background: linear-gradient(90deg, #F9E4B7, #D4AF37);
            color:#1C1C1C;
        }
        .aa-btn:hover { filter: brightness(.97); transform: translateY(-1px); }
        .aa-link { color: var(--aa-text); }
        .aa-link:hover { color: var(--aa-accent); }
        .aa-underline { background: linear-gradient(90deg, #F9E4B7, #D4AF37); height:2px; }
        .aa-border { border-color: var(--aa-line); }
        .aa-input::placeholder { color:#9CA3AF; }
        .aa-chip { background:#F3F4F6; }
        .aa-chip.active { background:#FFF7E0; border:1px solid #F3D99B; color:#7A5B06; }
    </style>
    @yield('seo')
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">


</head>
<body class="bg-white text-gray-900">


    {{-- ======================= HEADER ======================= --}}
    <header id="siteHeader" class="sticky top-0 z-50 transition-all duration-300 border-b border-transparent">
        <div class="aa-glass">
            <div class="aa-container mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between gap-4 py-3">

                    {{-- 🌟 Logo + marque (INLINE SVG) --}}
                    <a href="{{ route('front.index') }}" class="flex items-center gap-2 group">
                        {{-- SVG maison-A dorée (taille augmentée et alignée) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"
                            class="h-10 w-10 -mt-1 transition-transform duration-300 group-hover:scale-110">
                            <defs>
                                <linearGradient id="gold" x1="0" x2="1" y1="0" y2="1">
                                    <stop offset="0%" stop-color="#facc15"/>
                                    <stop offset="100%" stop-color="#b58900"/>
                                </linearGradient>
                                <filter id="shine" x="-50%" y="-50%" width="200%" height="200%">
                                    <feGaussianBlur in="SourceGraphic" stdDeviation="1.2" result="blur"/>
                                    <feMerge>
                                        <feMergeNode in="blur"/>
                                        <feMergeNode in="SourceGraphic"/>
                                    </feMerge>
                                </filter>
                            </defs>
                            <path d="M32 8L4 36h8v20h12V40h16v16h12V36h8L32 8z"
                                fill="url(#gold)" stroke="#d4af37" stroke-width="1.5"
                                class="transition-all duration-500 group-hover:drop-shadow-[0_0_6px_#facc15]"
                                filter="url(#shine)"/>
                            <rect x="20" y="30" width="24" height="4" fill="#facc15"/>
                        </svg>

                        {{-- Texte du logo --}}
                        <div class="leading-tight font-extrabold -mt-0.5">
                            <div class="text-[#b58900] text-lg tracking-tight">LLO</div>
                            <div class="text-[#b58900] text-lg -mt-1">PPART</div>
                        </div>
                    </a>

                    {{-- 🔍 Barre de recherche (ultra-moderne, responsive) --}}
                    <form action="{{ route('front.index') }}" method="GET"
                        class="hidden md:flex items-center gap-3 px-5 py-2.5 rounded-full border border-[#facc15]/40 bg-white/70 backdrop-blur-xl shadow-sm hover:shadow-lg transition-all duration-300 hover:scale-[1.01] group">

                        {{-- Champ principal : lieu --}}
                        <div class="flex items-center gap-2 pl-2">
                            <i class="fa-solid fa-location-dot text-[#b58900] text-sm opacity-80"></i>
                            <input name="q" value="{{ request('q') }}"
                                class="bg-transparent text-gray-700 placeholder-gray-400 focus:outline-none text-sm w-56"
                                type="text" placeholder="Une localité ou un type de logement? ">
                        </div>

                        <div class="h-6 w-px bg-gray-200"></div>

                        {{-- Min --}}
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-coins text-[#b58900] text-xs opacity-80"></i>
                            <input name="min" value="{{ request('min') }}"
                                class="bg-transparent focus:outline-none text-sm w-24 text-gray-700 placeholder-gray-400"
                                type="number" min="0" placeholder="Min FCFA">
                        </div>

                        <div class="h-6 w-px bg-gray-200"></div>

                        {{-- Max --}}
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-sack-dollar text-[#b58900] text-xs opacity-80"></i>
                            <input name="max" value="{{ request('max') }}"
                                class="bg-transparent focus:outline-none text-sm w-24 text-gray-700 placeholder-gray-400"
                                type="number" min="0" placeholder="Max FCFA">
                        </div>

                        {{-- Bouton recherche --}}
                        <button type="submit"
                            class="ml-2 flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#facc15] text-gray-900 font-semibold shadow-sm hover:bg-[#fddb4f] hover:shadow-md hover:scale-105 transition-all duration-300 focus:ring-2 focus:ring-[#facc15]/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="#1C1C1C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                            </svg>
                            <span class="text-sm tracking-wide">Rechercher</span>
                        </button>
                    </form>


                    {{-- ⚙️ Actions droite --}}
                    <div class="hidden md:flex items-center gap-5">
                        <a href="{{ route('front.index') }}" class="nav-link text-sm">Découvrir</a>
                        <a href="{{ route('dashboard') }}" class="nav-link text-sm">Espace</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-full border aa-border px-3 py-1.5 hover:bg-gray-50 transition">
                                {{-- user icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21a8 8 0 1 0-16 0"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <span class="text-sm">Mon espace</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm hover:text-[#b58900] transition">Connexion</a>
                            <a href="{{ route('register') }}" class="text-sm hover:text-[#b58900] transition">Créer un compte</a>
                        @endauth
                    </div>

                    {{-- 🍔 Burger mobile --}}
                    <button id="menuBtn" class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-full border aa-border hover:bg-white/10 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#b58900]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <line x1="3" y1="12" x2="21" y2="12"/>
                            <line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
                    </button>
                </div>

                {{-- 📱 Menu mobile déroulant --}}
                <div id="mobileMenu" class="md:hidden hidden gap-3 pb-4 pt-2">
                    <form action="{{ route('front.index') }}" method="GET"
                        class="grid gap-2 p-3 rounded-2xl border aa-border bg-white/90 backdrop-blur-md">
                        <input name="q" value="{{ request('q') }}" class="aa-input bg-gray-50 rounded-lg px-3 py-2 border aa-border" placeholder="Quartier, ville, mot-clé…">
                        <div class="grid grid-cols-2 gap-2">
                            <input name="min" value="{{ request('min') }}" class="aa-input bg-gray-50 rounded-lg px-3 py-2 border aa-border" type="number" min="0" placeholder="Min FCFA">
                            <input name="max" value="{{ request('max') }}" class="aa-input bg-gray-50 rounded-lg px-3 py-2 border aa-border" type="number" min="0" placeholder="Max FCFA">
                        </div>
                        <button class="w-full rounded-xl btn-gold px-4 py-2.5 font-medium">Rechercher</button>
                    </form>

                    <nav class="grid gap-1 bg-white/90 rounded-2xl border aa-border p-2 backdrop-blur-md">
                        <a href="{{ route('front.index') }}" class="px-4 py-2 rounded-lg hover:bg-gray-50">Découvrir</a>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-gray-50">Espace</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-gray-50">Mon espace</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg hover:bg-gray-50">Connexion</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg hover:bg-gray-50">Créer un compte</a>
                        @endauth
                    </nav>
                </div>
            </div>
        </div>

        {{-- fine border shadow animée --}}
        <div id="headerLine" class="h-px w-full bg-transparent transition-colors"></div>
    </header>




    {{-- ======================= HERO (optionnel) ======================= --}}
    @hasSection('hero')
        <section class="relative">
            @yield('hero')
        </section>
    @endif

    {{-- ======================= CONTENU ======================= --}}
    <main class="bg-white text-gray-900">

        @yield('content')
    </main>

{{-- ======================= FOOTER ======================= --}}
<footer class="mt-24 bg-gradient-to-br from-[#fdfcfb] to-[#f5f5f5] border-t border-[#e5e7eb]/60 shadow-inner relative overflow-hidden">

    {{-- ligne de brillance subtile --}}
    <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-[#facc15]/60 via-[#b58900]/80 to-transparent"></div>

    <div class="aa-container mx-auto px-6 py-14 grid gap-10 md:grid-cols-4 relative z-10">

        {{-- 🏠 Logo + description --}}
        <div class="space-y-4">
            <a href="{{ route('front.index') }}" class="flex items-center gap-3 group" aria-label="Retour à l’accueil">
                {{-- Inline SVG logo maison-A dorée (taille augmentée et alignée) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"
                    class="h-10 w-10 -mt-1 transition-transform duration-300 group-hover:scale-110">
                    <defs>
                        <linearGradient id="goldFooter" x1="0" x2="1" y1="0" y2="1">
                            <stop offset="0%" stop-color="#facc15"/>
                            <stop offset="100%" stop-color="#b58900"/>
                        </linearGradient>
                    </defs>
                    <path d="M32 8L4 36h8v20h12V40h16v16h12V36h8L32 8z"
                        fill="url(#goldFooter)" stroke="#d4af37" stroke-width="1.2"/>
                    <rect x="20" y="30" width="24" height="3.5" fill="#facc15"/>
                </svg>

                <div class="leading-tight font-extrabold -mt-0.5">
                    <div class="text-[#b58900] text-lg tracking-tight group-hover:text-[#facc15] transition-colors">LLO</div>
                    <div class="text-[#b58900] text-lg -mt-1 group-hover:text-[#facc15] transition-colors">PPART</div>
                </div>
            </a>

            <p class="text-sm text-gray-600 leading-relaxed max-w-xs">
                Votre plateforme de référence pour trouver des appartements modernes et élégants dans toute la région de Dakar.
            </p>
        </div>

        {{-- 🌍 Découvrir --}}
        <div>
            <h4 class="text-sm font-semibold mb-4 text-gray-800 uppercase tracking-wide">Découvrir</h4>
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a class="hover:text-[#b58900] transition-colors" href="{{ route('front.index') }}">Accueil</a></li>
                <li><a class="hover:text-[#b58900] transition-colors" href="{{ route('front.index') }}?min=0&max=250000">Budget ≤ 250 000 FCFA</a></li>
            </ul>
        </div>

        {{-- 💬 Aide --}}
        <div>
            <h4 class="text-sm font-semibold mb-4 text-gray-800 uppercase tracking-wide">Aide</h4>
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a class="hover:text-[#b58900] transition-colors" href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>

        {{-- 📱 Réseaux sociaux --}}
        <div>
            <h4 class="text-sm font-semibold mb-4 text-gray-800 uppercase tracking-wide">Nous suivre</h4>
            <div class="flex flex-wrap items-center gap-4">
                {{-- X / Twitter --}}
                <a href="https://x.com" target="_blank" aria-label="Twitter"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/60 border border-gray-300 
                    text-gray-700 shadow-sm hover:shadow-lg hover:text-[#b58900] hover:border-[#b58900] 
                    transition-all duration-300 hover:scale-110 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 1227" fill="currentColor" class="h-5 w-5">
                        <path d="M714.163 519.284 1160.89 0H1056.36L667.137 450.887 357.328 0H0l464.84 679.658L0 1226.37h104.53l407.51-472.11 326.1 472.11h357.33L714.163 519.284ZM562.56 687.153l-47.26-67.74L142.1 79.74h162.48l303.75 435.25 47.26 67.74 398.98 573.04H892.1L562.56 687.153Z"/>
                    </svg>
                </a>

                {{-- Instagram --}}
                <a href="https://instagram.com" target="_blank" aria-label="Instagram"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/60 border border-gray-300 
                    text-gray-700 shadow-sm hover:shadow-lg hover:text-[#b58900] hover:border-[#b58900] 
                    transition-all duration-300 hover:scale-110 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7.75 2A5.75 5.75 0 0 0 2 7.75v8.5A5.75 5.75 0 0 0 7.75 22h8.5A5.75 5.75 0 0 0 22 16.25v-8.5A5.75 5.75 0 0 0 16.25 2h-8.5Zm0 1.5h8.5A4.25 4.25 0 0 1 20.5 7.75v8.5a4.25 4.25 0 0 1-4.25 4.25h-8.5A4.25 4.25 0 0 1 3.5 16.25v-8.5A4.25 4.25 0 0 1 7.75 3.5ZM12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm0 1.5a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7Zm4.75-.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"/>
                    </svg>
                </a>

                {{-- Facebook --}}
                <a href="https://facebook.com" target="_blank" aria-label="Facebook"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/60 border border-gray-300 
                    text-gray-700 shadow-sm hover:shadow-lg hover:text-[#b58900] hover:border-[#b58900] 
                    transition-all duration-300 hover:scale-110 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 320 512" fill="currentColor">
                        <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S264.43 0 225.36 0C141.09 0 89.5 54.42 89.5 153.12v68.22H0V288h89.5v224h107.8V288z"/>
                    </svg>
                </a>

                {{-- LinkedIn --}}
                <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/60 border border-gray-300 
                    text-gray-700 shadow-sm hover:shadow-lg hover:text-[#b58900] hover:border-[#b58900] 
                    transition-all duration-300 hover:scale-110 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 448 512" fill="currentColor">
                        <path d="M100.28 448H7.4V149.4h92.88zm-46.44-338C24 110 0 85.7 0 56.1 0 26.7 24.6 0 54.2 0s54.2 26.7 54.2 56.1c0 29.6-24.2 53.9-54.6 53.9zM447.9 448h-92.7V302.4c0-34.7-12.5-58.4-43.8-58.4-23.9 0-38.2 16.1-44.4 31.7-2.3 5.6-2.9 13.4-2.9 21.2V448h-92.7s1.2-241.8 0-266.6h92.7v37.8c-.2.3-.5.7-.7 1h.7v-1c12.3-18.9 34.3-45.9 83.5-45.9 61 0 106.8 39.8 106.8 125.4V448z"/>
                    </svg>
                </a>

                {{-- TikTok --}}
                <a href="https://tiktok.com" target="_blank" aria-label="TikTok"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/60 border border-gray-300 
                    text-gray-700 shadow-sm hover:shadow-lg hover:text-[#b58900] hover:border-[#b58900] 
                    transition-all duration-300 hover:scale-110 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 448 512" fill="currentColor">
                        <path d="M448,209.9a210.1,210.1,0,0,1-122.1-38.9V351.4A160.59,160.59,0,1,1,166.9,192a155.5,155.5,0,0,1,24.2,1.9v80.5a80.54,80.54,0,1,0,56.3,77V0h78.5A128.35,128.35,0,0,0,448,128.4Z"/>
                    </svg>
                </a>

                {{-- Mail --}}
                <a href="mailto:contact@alloappart.sn" aria-label="Email"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/60 border border-gray-300 
                    text-gray-700 shadow-sm hover:shadow-lg hover:text-[#b58900] hover:border-[#b58900] 
                    transition-all duration-300 hover:scale-110 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H3Zm0 2h18l-9 6L3 7Zm0 2.2 7.8 5.2a1 1 0 0 0 1.4 0L20.9 9.2V17H3V9.2Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- 🧡 Ligne finale --}}
    <div class="border-t border-[#d4af37]/30 bg-transparent backdrop-blur-md">
        <div class="w-full py-4 flex flex-wrap items-center justify-center text-sm text-gray-700 tracking-wide text-center gap-x-3 gap-y-1">
            <span>© {{ date('Y') }} <span class="text-[#b58900] font-semibold hover:text-[#facc15] transition-colors">AlloAppart</span>, Inc.</span>
            <span class="text-[#d4af37]/60">·</span>
            <a href="{{ route('confidentialite') }}" class="hover:text-[#b58900] transition-colors">Confidentialité</a>
            <span class="text-[#d4af37]/60">·</span>
            <a href="{{ route('conditions') }}" class="hover:text-[#b58900] transition-colors">Conditions</a>
            <span class="text-[#d4af37]/60">·</span>
            <a href="{{ route('plan') }}" class="hover:text-[#b58900] transition-colors">Plan du site</a>
            <span class="text-[#d4af37]/60">·</span>
            <a href="{{ route('fonctionnement') }}" class="hover:text-[#b58900] transition-colors">Fonctionnement du site</a>
            <span class="text-[#d4af37]/60">·</span>
            <a href="{{ route('apropos') }}" class="hover:text-[#b58900] transition-colors">À propos</a>
        </div>
    </div>

</footer>





    {{-- ======================= JS léger pour interactions header/menu ======================= --}}
    <script>
        (function(){
            const header = document.getElementById('siteHeader');
            const headerLine = document.getElementById('headerLine');
            const menuBtn = document.getElementById('menuBtn');
            const mobileMenu = document.getElementById('mobileMenu');

            // Ombre et ligne quand on scrolle (effet sticky premium)
            let last = 0;
            const onScroll = () => {
                const y = window.scrollY || document.documentElement.scrollTop;
                header.style.boxShadow = y > 8 ? '0 10px 25px -20px rgba(0,0,0,.35)' : 'none';
                header.style.borderBottomColor = y > 8 ? 'var(--aa-line)' : 'transparent';
                headerLine.style.background = y > 8 ? 'linear-gradient(90deg, #F9E4B7, #D4AF37)' : 'transparent';
                last = y;
            };
            window.addEventListener('scroll', onScroll, { passive:true });
            onScroll();

            // Menu mobile
            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden'); // affiche/masque
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('grid');  // on applique display:grid
                    } else {
                        mobileMenu.classList.remove('grid');
                    }
                });
            }

        })();
    </script>
</body>
</html>
