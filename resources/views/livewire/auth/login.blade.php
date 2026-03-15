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
        $user = Auth::getProvider()->retrieveByCredentials([
            'email' => $this->email,
            'password' => $this->password
        ]);

        if (! $user || ! Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
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

<div class="h-screen flex flex-col md:flex-row overflow-hidden bg-white">

    {{-- ================= LEFT : FORMULAIRE ================= --}}
    <div class="w-full md:w-1/2 flex items-center justify-center p-6 lg:p-10">

        <div class="w-full max-w-md space-y-8 animate-fadeInLeft">

            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-800">
                    Connexion
                </h2>
                <p class="text-gray-500 text-sm">
                    Connectez-vous pour accéder à votre espace
                </p>
            </div>

            <x-auth-session-status class="text-green-600" :status="session('status')" />

            <form wire:submit="login" class="space-y-6">

                <flux:input
                    wire:model="email"
                    :label="__('Adresse e-mail')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="exemple@mail.com"
                />

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

                    @if (Route::has('password.request'))
                        <flux:link 
                            class="absolute right-0 top-0 text-sm text-[#b58900] hover:text-[#facc15]"
                            :href="route('password.request')" 
                            wire:navigate>
                            {{ __('Mot de passe oublié ?') }}
                        </flux:link>
                    @endif

                </div>

                <label class="flex items-center gap-2 text-sm text-gray-700">

                    <input type="checkbox"
                           wire:model="remember"
                           class="h-4 w-4 text-[#b58900] border-gray-300 rounded">

                    {{ __('Se souvenir de moi') }}

                </label>

                {{-- bouton connexion --}}
                <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full py-3 rounded-full
                        bg-[#0f172a]
                        text-[#facc15]
                        font-semibold tracking-wide
                        shadow-md
                        hover:shadow-lg hover:scale-[1.02]
                        transition-all duration-300
                        disabled:opacity-70 disabled:cursor-not-allowed">

                    {{-- texte normal --}}
                    <span wire:loading.remove wire:target="login">
                        Se connecter
                    </span>

                    {{-- pendant la connexion --}}
                    <span wire:loading wire:target="login">
                        En cours de connexion...
                    </span>

                </button>

            </form>

            {{-- inscription --}}
            <div class="text-center text-sm text-gray-600">
                Pas encore de compte ?

                <a href="{{ route('register') }}"
                   class="text-[#b58900] font-medium hover:text-[#facc15] hover:underline ml-1">

                   Créer un compte

                </a>
            </div>

            {{-- retour accueil --}}
            <div class="text-center text-sm text-gray-500">
                <a href="{{ route('front.index') }}"
                   class="hover:text-[#b58900] transition">

                    ← Retour à l’accueil

                </a>
            </div>

        </div>

    </div>


    {{-- ================= RIGHT : BRANDING ================= --}}
    <div class="hidden md:flex md:w-1/2 bg-[#0f172a] items-center justify-center relative overflow-hidden">

        {{-- cercles décoratifs --}}
        <div class="absolute inset-0 opacity-20 pointer-events-none">

            <div class="absolute top-10 left-10 w-72 h-72 bg-yellow-400 rounded-full mix-blend-overlay"></div>

            <div class="absolute bottom-10 right-10 w-96 h-96 bg-yellow-400 rounded-full mix-blend-overlay"></div>

        </div>
{{-- contenu branding --}}
<div class="relative z-10 flex flex-col items-center text-center gap-8 px-10">

    {{-- Logo officiel --}}
    {{-- Logo + marque (INLINE SVG) --}}
    <a class="flex items-center gap-0 group">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 64 64"
             class="h-24 w-24 -mt-1 transition-transform duration-300 group-hover:scale-110">

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
                  fill="url(#gold)"
                  stroke="#d4af37"
                  stroke-width="1.5"
                  class="transition-all duration-500 group-hover:drop-shadow-[0_0_6px_#facc15]"
                  filter="url(#shine)"/>

            <rect x="20" y="30" width="24" height="4" fill="#facc15"/>

        </svg>

        <div class="leading-tight font-extrabold -mt-2">
            <div class="text-[#b58900] text-5xl tracking-tight -ml-3">LLO</div>
            <div class="text-[#b58900] text-5xl -mt-3">PPART</div>
        </div>

    </a>

    {{-- slogan --}}
    <p class="text-xl italic text-[#facc15]/90 tracking-wide max-w-md leading-relaxed text-center font-medium">
        Votre prochain appartement, plus simple et plus rapide
    </p>

</div>

    </div>

</div>