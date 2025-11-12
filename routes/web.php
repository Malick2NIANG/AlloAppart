<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FavorisController;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
|
| Ici se trouvent toutes les routes de ton application web AlloAppart.
| On conserve celles générées par Volt/Fortify + on ajoute celles du front.
|
*/

/* ============================================================
| 🏠 PAGES PUBLIQUES (Front)
============================================================ */
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/home', fn() => redirect()->route('front.index'))->name('home');
Route::get('/appartements/{id}', [FrontController::class, 'show'])->name('front.show');

/* ============================================================
| ✉️ MESSAGERIE ET AVIS
============================================================ */
// Envoi d’un message au bailleur (auth obligatoire)
Route::post('/appartements/{id}/message', [FrontController::class, 'sendMessage'])
    ->middleware('auth')
    ->name('front.message.send');

// Enregistrement d’un avis (auth obligatoire)
Route::post('/appartements/{id}/avis', [AvisController::class, 'store'])
    ->middleware('auth')
    ->name('avis.store');

/* ============================================================
| ❤️ FAVORIS (ajout, retrait et affichage)
============================================================ */
// 🔄 Ajout ou retrait d’un appartement des favoris
Route::post('/favoris/{appartement}', [FavorisController::class, 'toggle'])
    ->name('favoris.toggle');

// 📋 Page “Mes favoris” (réservée aux utilisateurs connectés)
Route::middleware('auth')->group(function () {
    Route::get('/mes-favoris', [FavorisController::class, 'index'])->name('favoris.index');
});

/* ============================================================
| 📊 TABLEAU DE BORD UTILISATEUR
============================================================ */
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/* ============================================================
| ⚙️ PARAMÈTRES DU COMPTE (Volt + Fortify)
============================================================ */
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
Route::get('/social/twitter', fn() => redirect()->away('https://x.com/alloappart'))->name('social.twitter');
Route::get('/social/instagram', fn() => redirect()->away('https://instagram.com/alloappart'))->name('social.instagram');
Route::get('/social/facebook', fn() => redirect()->away('https://facebook.com/alloappart'))->name('social.facebook');
Route::get('/social/linkedin', fn() => redirect()->away('https://linkedin.com/company/alloappart'))->name('social.linkedin');
Route::get('/social/tiktok', fn() => redirect()->away('https://tiktok.com/@alloappart'))->name('social.tiktok');

/* ============================================================
| 🔐 AUTHENTIFICATION (Fortify / Volt)
============================================================ */
require __DIR__ . '/auth.php';
