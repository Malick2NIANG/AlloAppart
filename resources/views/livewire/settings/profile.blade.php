<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

use function Livewire\Volt\layout;
use function Livewire\Volt\title;

layout('layouts.front');
title('Profil');

new class extends Component {
    public string $nom = '';
    public string $email = '';

    public function mount(): void
    {
        $u = Auth::user();
        $this->nom = $u->nom ?? $u->name ?? '';
        $this->email = $u->email ?? '';
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);

        // Supporte ton modèle (nom) ou starter kit (name)
        if (array_key_exists('nom', $user->getAttributes())) {
            $user->nom = $validated['nom'];
        } else {
            $user->name = $validated['nom'];
        }

        $user->email = $validated['email'];

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Session::flash('success', 'Profil mis à jour.');
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
};
?>

<div class="aa-container mx-auto px-4 sm:px-6 py-10">
    <div class="max-w-3xl mx-auto">

        <div class="aa-shadow bg-white rounded-3xl border aa-border p-6 sm:p-8">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Profil</h1>
                    <p class="text-gray-600 mt-1">Modifie ton nom et ton e-mail.</p>
                </div>

                <a href="{{ route('dashboard') }}"
                   class="text-sm font-semibold text-[#b58900] hover:text-[#facc15] transition">
                    Retour
                </a>
            </div>

            @if (session('success'))
                <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit="updateProfileInformation" class="mt-8 space-y-6">
                <div class="grid gap-2">
                    <label class="text-sm font-semibold text-gray-800">Nom complet</label>
                    <input wire:model="nom" type="text" autocomplete="name" required
                           class="w-full rounded-2xl border aa-border bg-white px-4 py-3 text-gray-900 placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-[#facc15]/40"
                           placeholder="Ex: Malick Niang">
                    @error('nom') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-2">
                    <label class="text-sm font-semibold text-gray-800">Email</label>
                    <input wire:model="email" type="email" autocomplete="email" required
                           class="w-full rounded-2xl border aa-border bg-white px-4 py-3 text-gray-900 placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-[#facc15]/40"
                           placeholder="exemple@mail.com">
                    @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                        <div class="mt-3 rounded-2xl border aa-border bg-[#fffaf0] px-4 py-3 text-sm text-gray-700">
                            <div class="flex flex-wrap items-center gap-2">
                                <span>Ton adresse email n’est pas vérifiée.</span>
                                <button type="button"
                                        wire:click.prevent="resendVerificationNotification"
                                        class="font-semibold text-[#b58900] hover:text-[#facc15] transition">
                                    Renvoyer l’email
                                </button>
                            </div>

                            @if (session('status') === 'verification-link-sent')
                                <div class="mt-2 font-medium text-green-700">
                                    Un nouveau lien a été envoyé.
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-end">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex justify-center rounded-2xl border aa-border px-5 py-3 font-semibold text-gray-800 hover:bg-gray-50 transition">
                        Annuler
                    </a>

                    <button type="submit"
                            class="inline-flex justify-center rounded-2xl px-6 py-3 font-extrabold aa-btn aa-shadow transition">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8">
            <livewire:settings.delete-user-form />
        </div>

    </div>
</div>
