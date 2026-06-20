<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('', 'SISTEM AGENDA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- <div class="min-h-screen bg-gray-100" > -->
            <div class="min-h-screen bg-cover bg-top" style="background-image: url('{{ asset('http://localhost/bg_web.png') }}')">

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header style="background-color: #004eb5;">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 !bg-primaryblue">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>

        <div id="pdfModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-7xl h-full max-h-40xl flex flex-col">
                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Preview Konten</h3> {{-- Ubah judul default --}}
                    <button type="button" class="text-gray-400 hover:text-gray-600" id="closeModalButton">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex-grow p-4">
                    <iframe id="pdfIframe" src="" width="100%" height="100%" frameborder="0"></iframe>
                </div>
            </div>
        </div>

    @stack('scripts')
    </body>
</html>
