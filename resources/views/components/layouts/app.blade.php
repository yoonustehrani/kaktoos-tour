<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body dir="rtl" class="w-screen h-screen overflow-x-hidden relative">
        {{-- <div class="fixed bottom-3 left-3 z-50">
            <p class="text-grenn-800">kos</p>
        </div> --}}
        @session('alert')
            <div class="fixed bottom-3 z-50 left-3 text-white bg-gray-900 w-fit h-fit py-2 px-6 rounded-md rounded-bl-none">
                <p class="text-grenn-800">{{ session()->get('alert')['message'] }}</p>
            </div>
        @endsession
        {{ $slot }}
    </body>
</html>
