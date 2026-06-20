<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Maintenance Mode') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center" style="font-size: 2rem; font-weight: bold;">
                    🚧 {{ __("Situs Sedang Dalam Perawatan") }} 🚧
                </div>

                <div class="p-6 text-center text-gray-700" style="font-size: 1.5rem;">
                    {{ __("Kami sedang melakukan pemeliharaan sistem. Silakan kembali lagi nanti.") }}
                </div>

                <div class="p-6 text-center text-gray-500" style="font-size: 1.2rem;">
                    {{ __("Terima kasih atas kesabaran Anda.") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
