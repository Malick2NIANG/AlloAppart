<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        // Messages envoyés par le client connecté
        $messages = Message::with([
                'destinataire:id,nom,email,telephone',
                'appartement:id,titre,ville,prix',
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('front.messages', compact('messages'));
    }
}
