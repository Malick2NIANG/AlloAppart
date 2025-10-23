<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'AlloAppart — Authentification' }}</title>

    {{-- 🎨 Favicon AlloAppart (maison dorée) --}}
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Feuilles de style & scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-gradient-to-br from-[#fffefb] via-[#fdf8e7] to-[#fffaf1] text-gray-900 flex flex-col items-center justify-center">
    
    {{-- 🌟 Nouveau logo AlloAppart --}}
    <div class="text-center mb-8 animate-fadeIn">
        <a href="{{ route('front.index') }}" class="inline-flex flex-col items-center group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"
                class="h-16 w-16 drop-shadow-md transition-transform duration-500 group-hover:scale-110">
                <defs>
                    <linearGradient id="goldAllo" x1="0" x2="1" y1="0" y2="1">
                        <stop offset="0%" stop-color="#facc15"/>
                        <stop offset="100%" stop-color="#b58900"/>
                    </linearGradient>
                </defs>
                <path d="M32 8L4 36h8v20h12V40h16v16h12V36h8L32 8z"
                      fill="url(#goldAllo)" stroke="#d4af37" stroke-width="1.4"/>
            </svg>
            <span class="text-[#b58900] font-extrabold text-2xl tracking-tight mt-1">
                AlloAppart
            </span>
        </a>
    </div>

    {{-- 🔐 Contenu de la page (login/register/etc.) --}}
    <div class="w-full max-w-md bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-[#f6e7c5]/60 p-8 animate-fadeIn">
        {{ $slot }}
    </div>

    {{-- ✨ Animation d’apparition douce --}}
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>

    @livewireScripts
</body>
</html>
