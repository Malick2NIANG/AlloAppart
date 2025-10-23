<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * 📨 Affiche la page de contact
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * 📨 Gère l’envoi du formulaire de contact
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        // 🔒 (Plus tard, tu pourras envoyer l'email ici)
        // Mail::to('support@alloappart.sn')->send(new ContactMail($request->all()));

        return back()->with('success', '✅ Merci ! Votre message a bien été envoyé. Nous vous répondrons rapidement.');
    }

    /**
     * 🧾 Pages statiques du footer
     */
    public function conditions()      { return view('pages.conditions'); }
    public function confidentialite() { return view('pages.confidentialite'); }
    public function fonctionnement()  { return view('pages.fonctionnement'); }
    public function plan()            { return view('pages.plan'); }
    public function apropos()         { return view('pages.apropos'); }
}
