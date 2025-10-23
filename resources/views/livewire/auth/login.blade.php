<?php 

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        $user = $this->validateCredentials();

        if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
            Session::put([
                'login.id' => $user->getKey(),
                'login.remember' => $this->remember,
            ]);
            $this->redirect(route('two-factor.login'), navigate: true);
            return;
        }

        Auth::login($user, $this->remember);
        RateLimiter::clear($this->throttleKey());
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    protected function validateCredentials(): User
    {
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);
        if (! $user || ! Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }
        return $user;
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) return;
        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($this->throttleKey());
        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; 
?>

{{-- ============================ PAGE DE CONNEXION ALLÉGÉE ET THÉMATIQUE ============================ --}}
<div class="flex flex-col gap-6 animate-fadeIn">

    {{-- 🧭 En-tête claire et raffinée --}}
    <x-auth-header 
        :title="__('Connexion à votre espace')" 
        :description="__('Connectez-vous pour accéder à vos annonces, messages et informations personnelles.')" 
    />

    {{-- 🔔 Message de session --}}
    <x-auth-session-status class="text-center mb-4 text-green-600" :status="session('status')" />

    {{-- 🔐 Formulaire --}}
    <form method="POST" wire:submit="login" class="flex flex-col gap-6">
        @csrf

        {{-- Adresse e-mail --}}
        <flux:input
            wire:model="email"
            :label="__('Adresse e-mail')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="exemple@mail.com"
        />

        {{-- Mot de passe --}}
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Mot de passe')"
                type="password"
                required
                autocomplete="current-password"
                placeholder="Votre mot de passe"
                viewable
            />
            {{-- Lien mot de passe oublié --}}
            @if (Route::has('password.request'))
                <flux:link 
                    class="absolute top-0 text-sm end-0 mt-1 text-[#b58900] hover:text-[#facc15] transition" 
                    :href="route('password.request')" 
                    wire:navigate>
                    {{ __('Mot de passe oublié ?') }}
                </flux:link>
            @endif
        </div>

        {{-- Se souvenir de moi --}}
        <div class="flex items-center gap-2">
            <input wire:model="remember" id="remember" type="checkbox"
                class="h-4 w-4 text-[#b58900] border-gray-300 rounded focus:ring-[#facc15]">
            <label for="remember" class="text-sm text-gray-700">{{ __('Se souvenir de moi') }}</label>
        </div>

        {{-- Bouton de connexion stylé --}}
        <button type="submit"
            class="w-full py-3 rounded-full bg-gradient-to-r from-[#facc15] to-[#b58900]
                   text-[#1C1C1C] font-semibold tracking-wide shadow-md 
                   hover:shadow-lg hover:scale-[1.02] transition-all duration-300 focus:ring-2 focus:ring-[#f6e7c5]/50">
            <i class="fa-solid fa-right-to-bracket mr-2"></i> {{ __('Se connecter') }}
        </button>
    </form>

    {{-- 🔁 Vers inscription --}}
    @if (Route::has('register'))
        <div class="text-center text-sm text-gray-600 mt-6">
            <span>{{ __('Pas encore de compte ?') }}</span>
            <a href="{{ route('register') }}" 
               class="text-[#b58900] font-medium hover:text-[#facc15] hover:underline ml-1 transition">
               {{ __('Créer un compte') }}
            </a>
        </div>
    @endif

    {{-- ⬅️ Retour à l'accueil --}}
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
