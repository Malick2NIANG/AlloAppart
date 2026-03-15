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
    public string $nom = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'email.unique' => 'Cet e-mail est déjà utilisé.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $userData = [
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'role' => 'client',
            'password' => Hash::make($validated['password']),
        ];

        event(new Registered(($user = User::create($userData))));

        Auth::login($user);
        Session::regenerate();

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
};

?>

<div class="h-screen flex flex-col md:flex-row overflow-hidden bg-white">

    {{-- ================= LEFT : FORMULAIRE ================= --}}
    <div class="w-full md:w-1/2 flex items-center justify-center p-3 lg:p-5">

        <div class="w-full max-w-md space-y-4 animate-fadeInLeft">

            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-800">
                    Créer un compte
                </h2>
                <p class="text-gray-500 text-sm">
                    Rejoignez AlloAppart en quelques secondes
                </p>
            </div>

            <x-auth-session-status class="text-green-600" :status="session('status')" />

            <form wire:submit="register" class="space-y-3">

                <flux:input
                    wire:model="nom"
                    :label="__('Nom complet')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Ex : Malick Niang"
                />

                <flux:input
                    wire:model="email"
                    :label="__('Adresse e-mail')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="exemple@mail.com"
                />

                <flux:input
                    wire:model="password"
                    :label="__('Mot de passe')"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Créer un mot de passe"
                    viewable
                />

                <flux:input
                    wire:model="password_confirmation"
                    :label="__('Confirmer le mot de passe')"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Confirmer le mot de passe"
                    viewable
                />

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

                    <span wire:loading.remove wire:target="register">
                        Créer un compte
                    </span>

                    <span wire:loading wire:target="register">
                        Création du compte...
                    </span>

                </button>

            </form>

            <div class="text-center text-sm text-gray-600">
                Vous avez déjà un compte ?

                <a href="{{ route('login') }}"
                   class="text-[#b58900] font-medium hover:text-[#facc15] hover:underline ml-1">
                   Se connecter
                </a>
            </div>

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

        <div class="absolute inset-0 opacity-20 pointer-events-none">

            <div class="absolute top-10 left-10 w-72 h-72 bg-yellow-400 rounded-full mix-blend-overlay"></div>

            <div class="absolute bottom-10 right-10 w-96 h-96 bg-yellow-400 rounded-full mix-blend-overlay"></div>

        </div>

        <div class="relative z-10 flex flex-col items-center text-center gap-8 px-10">

            <a class="flex items-center gap-0 group">

                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 64 64"
                     class="h-24 w-24 -mt-1">

                    <defs>
                        <linearGradient id="gold" x1="0" x2="1" y1="0" y2="1">
                            <stop offset="0%" stop-color="#facc15"/>
                            <stop offset="100%" stop-color="#b58900"/>
                        </linearGradient>
                    </defs>

                    <path d="M32 8L4 36h8v20h12V40h16v16h12V36h8L32 8z"
                          fill="url(#gold)"
                          stroke="#d4af37"
                          stroke-width="1.5"/>

                    <rect x="20" y="30" width="24" height="4" fill="#facc15"/>

                </svg>

                <div class="leading-tight font-extrabold -mt-2">
                    <div class="text-[#b58900] text-5xl tracking-tight -ml-3">LLO</div>
                    <div class="text-[#b58900] text-5xl -mt-3">PPART</div>
                </div>

            </a>

            <p class="text-xl italic text-[#facc15]/90 tracking-wide max-w-md leading-relaxed text-center font-medium">
                Votre prochain appartement, plus simple et plus rapide
            </p>

        </div>

    </div>

</div>