{{-- resources/views/front/messages.blade.php --}}
@extends('layouts.front')

@section('title', 'Mes messages — AlloAppart')

@section('content')
<section class="aa-container mx-auto px-4 sm:px-6 py-20">

    <div class="text-center mb-14">
        <h1 class="text-3xl md:text-4xl font-bold text-[#1C1C1C] mb-2">💬 Mes messages</h1>
        <p class="text-gray-600">Retrouvez ici les messages que vous avez envoyés aux bailleurs.</p>
        <div class="w-20 h-[3px] bg-[#facc15] mx-auto mt-4 rounded-full"></div>
    </div>

    @if($messages->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($messages as $msg)
                <div class="bg-white/80 backdrop-blur-xl border aa-border rounded-2xl p-5 shadow-sm hover:shadow-lg transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="text-sm text-gray-500">Appartement</div>
                            <div class="font-semibold text-gray-900 truncate">
                                {{ $msg->appartement->titre ?? '—' }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ optional($msg->created_at)->diffForHumans() }}
                            </div>
                        </div>

                        @if(!$msg->lu)
                            <span class="shrink-0 px-2 py-1 text-xs rounded-full bg-[#fff5d6] text-[#b58900] border border-[#facc15]/50">
                                Non lu
                            </span>
                        @else
                            <span class="shrink-0 px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 border border-green-200">
                                Lu
                            </span>
                        @endif
                    </div>

                    <div class="mt-4 text-sm text-gray-700 line-clamp-3">
                        {{ $msg->contenu }}
                    </div>

                    <div class="mt-5 pt-4 border-t aa-border">
                        <div class="text-xs text-gray-500 mb-1">Bailleur</div>
                        <div class="text-sm font-medium text-gray-900">
                            {{ $msg->destinataire->nom ?? '—' }}
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ $msg->destinataire->email ?? '' }}
                        </div>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('front.show', $msg->appartement_id) }}"
                               class="flex-1 text-center btn-gold py-2 rounded-full font-semibold text-sm">
                                Voir l’annonce
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($messages->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $messages->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-20 text-gray-500">
            <p class="text-lg font-medium mb-2">Aucun message pour le moment</p>
            <p class="text-sm text-gray-400">Contactez un bailleur depuis une annonce pour démarrer une discussion.</p>
            <a href="{{ route('front.index') }}"
               class="inline-flex items-center gap-2 mt-6 px-6 py-2.5 bg-[#facc15] text-[#1C1C1C] font-medium rounded-full shadow-md hover:scale-105 transition">
                <i class="fa-solid fa-arrow-left"></i> Retour au catalogue
            </a>
        </div>
    @endif

</section>
@endsection
