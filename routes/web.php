<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FavorisController; // ✅ ajouté

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
|
| Ici se trouvent toutes les routes de ton application web.
| On conserve celles générées par Volt/Fortify + on ajoute celles du front AlloAppart.
|
*/

// 🏠 Page d’accueil AlloAppart (liste des appartements disponibles)
Route::get('/', [FrontController::class, 'index'])->name('front.index');

// Alias pour "home" (utilisé par Fortify/Volt après connexion)
Route::get('/home', fn() => redirect()->route('front.index'))->name('home');

// 🏘️ Détail d’un appartement
Route::get('/appartements/{id}', [FrontController::class, 'show'])->name('front.show');

// ✉️ Envoi d’un message au bailleur (réservé aux utilisateurs connectés)
Route::post('/appartements/{id}/message', [FrontController::class, 'sendMessage'])
    ->middleware('auth')
    ->name('front.message.send');

// ⭐ Enregistrement d’un avis (réservé aux utilisateurs connectés)
Route::post('/appartements/{id}/avis', [AvisController::class, 'store'])
    ->middleware('auth')
    ->name('avis.store');

/*
|--------------------------------------------------------------------------
| ❤️ FAVORIS (ajout / suppression)
|--------------------------------------------------------------------------
| Gère les actions d’ajout et de retrait d’un appartement dans les favoris.
| - Si l’utilisateur n’est pas connecté, il est redirigé vers /login.
| - Si connecté, le favori est ajouté ou retiré instantanément.
*/
Route::post('/favoris/{appartement}', [FavorisController::class, 'toggle'])
    ->name('favoris.toggle');

// 📊 Tableau de bord et paramètres utilisateur
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ⚙️ Paramètres du compte via Livewire Volt
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

/*
|--------------------------------------------------------------------------
| 🌍 PAGES STATIQUES (Footer)
|--------------------------------------------------------------------------
| Ces pages sont affichées dans le footer et le header (liens de navigation).
| Les vues correspondantes sont à placer dans /resources/views/pages/
| Exemples : pages/contact.blade.php, pages/confidentialite.blade.php, etc.
*/

Route::controller(PageController::class)->group(function () {
    // 📞 Page contact (formulaire + traitement)
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'sendContact')->name('contact.send');

    // 📄 Pages statiques simples
    Route::view('/conditions', 'pages.conditions')->name('conditions');
    Route::view('/confidentialite', 'pages.confidentialite')->name('confidentialite');
    Route::view('/fonctionnement', 'pages.fonctionnement')->name('fonctionnement');
    Route::view('/plan-du-site', 'pages.plan')->name('plan');
    Route::view('/a-propos', 'pages.apropos')->name('apropos');

    // 🍪 Politique des cookies
    Route::view('/cookies', 'pages.cookies')->name('cookies');
});

/*
|--------------------------------------------------------------------------
| 🔗 RÉSEAUX SOCIAUX (redirections externes)
|--------------------------------------------------------------------------
| Permet de centraliser les liens des icônes du footer.
| Ainsi tu peux les modifier ici sans toucher aux vues.
*/

Route::get('/social/twitter', fn() => redirect()->away('https://x.com/alloappart'))->name('social.twitter');
Route::get('/social/instagram', fn() => redirect()->away('https://instagram.com/alloappart'))->name('social.instagram');
Route::get('/social/facebook', fn() => redirect()->away('https://facebook.com/alloappart'))->name('social.facebook');
Route::get('/social/linkedin', fn() => redirect()->away('https://linkedin.com/company/alloappart'))->name('social.linkedin');
Route::get('/social/tiktok', fn() => redirect()->away('https://tiktok.com/@alloappart'))->name('social.tiktok');

// 🔐 Auth routes (login, register, logout, etc.)
require __DIR__ . '/auth.php';
