<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.front', function ($view) {
            $nonLusCount = 0;

            if (Auth::check()) {
                $nonLusCount = Message::where('user_id', Auth::id())
                    ->where('lu', false) // ou ->where('lu', 0)
                    ->count();
            }

            $view->with('headerNonLusCount', $nonLusCount);
        });
    }
}
