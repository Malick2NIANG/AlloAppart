<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);
        Session::regenerate();

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
};
?>

{{-- ============================ PAGE D’INSCRIPTION HARMONISÉE ============================ --}}
<div class="flex flex-col gap-6 animate-fadeIn">

    {{-- 🧭 En-tête dorée et élégante --}}
    <x-auth-header 
        :title="__('Créer un compte AlloAppart')" 
        :description="__('Renseignez vos informations ci-dessous pour créer votre compte personnel.')" 
    />

    {{-- 🔔 Message de session --}}
    <x-auth-session-status class="text-center mb-4 text-green-600" :status="session('status')" />

    {{-- 🧩 Formulaire d’inscription --}}
    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        @csrf

        {{-- Nom complet --}}
        <flux:input
            wire:model="name"
            :label="__('Nom complet')"
            type="text"
            required
            autofocus
            autocomplete="name"
            placeholder="Ex : Malick Niang"
        />

        {{-- Adresse e-mail --}}
        <flux:input
            wire:model="email"
            :label="__('Adresse e-mail')"
            type="email"
            required
            autocomplete="email"
            placeholder="exemple@mail.com"
        />

        {{-- Mot de passe --}}
        <flux:input
            wire:model="password"
            :label="__('Mot de passe')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="Créer un mot de passe"
            viewable
        />

        {{-- Confirmation --}}
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirmer le mot de passe')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="Confirmer le mot de passe"
            viewable
        />

        {{-- Bouton inscription stylé --}}
        <button type="submit"
            class="w-full py-3 rounded-full bg-gradient-to-r from-[#facc15] to-[#b58900]
                   text-[#1C1C1C] font-semibold tracking-wide shadow-md 
                   hover:shadow-lg hover:scale-[1.02] transition-all duration-300 focus:ring-2 focus:ring-[#f6e7c5]/50">
            <i class="fa-solid fa-user-plus mr-2"></i> {{ __('Créer un compte') }}
        </button>
    </form>

    {{-- 🔁 Vers connexion --}}
    <div class="text-center text-sm text-gray-600 mt-6">
        <span>{{ __('Vous avez déjà un compte ?') }}</span>
        <a href="{{ route('login') }}" 
           class="text-[#b58900] font-medium hover:text-[#facc15] hover:underline ml-1 transition">
           {{ __('Se connecter') }}
        </a>
    </div>

    {{-- ⬅️ Retour à l’accueil --}}
    <div class="text-center mt-4">
        <a href="{{ route('front.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#b58900] transition">
            <i class="fa-solid fa-arrow-left"></i> {{ __('Retour à l’accueil') }}
        </a>
    </div>

    {{-- ✨ Animation subtile --}}
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</div>
