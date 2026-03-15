<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
| AlloAppart — Public + Auth + Rôles
|--------------------------------------------------------------------------
*/

/* ============================================================
| 🏠 PAGES PUBLIQUES (Front)
============================================================ */
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/home', fn () => redirect()->route('front.index'))->name('home');
Route::get('/appartements/{id}', [FrontController::class, 'show'])->name('front.show');

/* ============================================================
| ❤️ FAVORIS (toggle : public, controller gère guest)
============================================================ */
Route::post('/favoris/{appartement}', [FavorisController::class, 'toggle'])
    ->name('favoris.toggle');

/* ============================================================
| 🌍 PAGES STATIQUES (Footer)
============================================================ */
Route::controller(PageController::class)->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'sendContact')->name('contact.send');

    Route::view('/conditions', 'pages.conditions')->name('conditions');
    Route::view('/confidentialite', 'pages.confidentialite')->name('confidentialite');
    Route::view('/fonctionnement', 'pages.fonctionnement')->name('fonctionnement');
    Route::view('/plan-du-site', 'pages.plan')->name('plan');
    Route::view('/a-propos', 'pages.apropos')->name('apropos');
    Route::view('/cookies', 'pages.cookies')->name('cookies');
});

/* ============================================================
| 🔗 RÉSEAUX SOCIAUX (liens externes)
============================================================ */
Route::get('/social/twitter', fn () => redirect()->away('https://x.com/alloappart'))->name('social.twitter');
Route::get('/social/instagram', fn () => redirect()->away('https://instagram.com/alloappart'))->name('social.instagram');
Route::get('/social/facebook', fn () => redirect()->away('https://facebook.com/alloappart'))->name('social.facebook');
Route::get('/social/linkedin', fn () => redirect()->away('https://linkedin.com/company/alloappart'))->name('social.linkedin');
Route::get('/social/tiktok', fn () => redirect()->away('https://tiktok.com/@alloappart'))->name('social.tiktok');

/* ============================================================
| 🔒 ROUTES PROTÉGÉES (auth obligatoire)
============================================================ */
Route::middleware(['auth'])->group(function () {

    // ✉️ Messagerie (envoi depuis fiche appartement)
    Route::post('/appartements/{id}/message', [FrontController::class, 'sendMessage'])
        ->name('front.message.send');

    // 💬 Page "Mes messages"
    Route::get('/mes-messages', [MessageController::class, 'index'])
        ->name('messages.index');

    // ✅ Alias pour ton client.blade actuel (route('client.messages'))
    Route::get('/client/messages', fn () => redirect()->route('messages.index'))
        ->name('client.messages');

    // ⭐ Avis
    Route::post('/appartements/{id}/avis', [AvisController::class, 'store'])
        ->name('avis.store');

    // ❤️ Page favoris
    Route::get('/mes-favoris', [FavorisController::class, 'index'])
        ->name('favoris.index');

    // ⚙️ Paramètres (Volt + Fortify)
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

/* ============================================================
| 📊 DASHBOARD (auth) => redirection selon rôle
============================================================ */
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin'    => redirect()->route('admin.home'),
        'bailleur' => redirect()->route('bailleur.home'),
        default    => redirect()->route('client.home'),
    };
})
->middleware(['auth'])
->name('dashboard');

/* ============================================================
| 🧭 ESPACES PAR RÔLE (auth + role)
============================================================ */
Route::middleware(['auth'])->group(function () {

    Route::view('/admin', 'roles.admin')
        ->middleware('role:admin')
        ->name('admin.home');

    Route::view('/bailleur', 'roles.bailleur')
        ->middleware('role:bailleur')
        ->name('bailleur.home');

    Route::view('/client', 'roles.client')
        ->middleware('role:client')
        ->name('client.home');
});

/* ============================================================
| 🔐 AUTHENTIFICATION (Fortify / Volt)
============================================================ */
require __DIR__ . '/auth.php';
