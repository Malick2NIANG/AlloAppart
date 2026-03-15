<x-layouts.app :title="__('Espace admin')">
    <div class="flex flex-col gap-6">

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <h1 class="text-xl font-semibold">Admin : {{ auth()->user()->nom }}</h1>
            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-300">
                Tableau de bord admin (gestion utilisateurs / annonces / modération — à brancher ensuite).
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="text-sm text-neutral-500">Stats</div>
                <div class="mt-2 text-2xl font-semibold">—</div>
                <div class="mt-1 text-xs text-neutral-500">À connecter</div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="text-sm text-neutral-500">Actions</div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('profile.edit') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-neutral-200 px-4 py-2 text-sm hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800"
                       wire:navigate>
                        Paramètres
                    </a>

                    <a href="{{ route('front.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-neutral-200 px-4 py-2 text-sm hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-800">
                        Retour au site
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
