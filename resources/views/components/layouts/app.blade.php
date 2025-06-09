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
        {{ $slot }}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @session('alert')
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-start",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    title: "{{ session()->get('alert')['message'] }}",
                    icon: "{{ session()->get('alert')['level'] }}"
                });
            </script>
            {{-- <div class="fixed bottom-3 z-50 left-3 text-white bg-gray-900 w-fit h-fit py-2 px-6 rounded-md rounded-bl-none">
                <p class="text-grenn-800">{{ session()->get('alert')['message'] }}</p>
            </div> --}}
        @endsession
    </body>
</html>
