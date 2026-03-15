{{-- resources/views/layouts/front-settings.blade.php --}}
@extends('layouts.front')

@section('content')
    <div class="aa-container mx-auto px-4 sm:px-6 py-10">
        <div class="max-w-3xl mx-auto">
            @yield('settings_content')
        </div>
    </div>
@endsection
