<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Daftar Surat Keluar') }}
        </h2>
    </x-slot>
    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Daftar Surat Keluar </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                        Berikut adalah surat-surat keluar yang menunggu persetujuan dari Anda sebagai Kabid.
                    </p>

                    {{-- Notifikasi --}}
                    <!-- @if(session('success'))
                        <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-200 rounded">
                            {{ session('error') }}
                        </div>
                    @endif -->

                    {{-- Daftar Surat --}}
                    @forelse ($suratList as $surat)
                        <div class="bg-white dark:bg-gray-700 p-4 mb-4 rounded shadow border border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            <strong>Perihal:</strong> {{ $surat->perihal }}<br>
                        </h3>

                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <strong>Sifat:</strong>{{ $surat->sifat }}<br>
                            <!-- <strong>Perihal:</strong> {{ $surat->perihal }}<br> -->
                            <strong>No Surat:</strong> {{ $surat->nomor_surat }}<br>
                            <strong>Bidang:</strong> {{ $surat->disposisi }}<br>
                            <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $surat->status_persetujuan)) }}
                        </p>

                        {{-- Tampilkan isi surat sebagai teks biasa --}}
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Isi Surat:</label>
                                <div class="mt-4">
                                   <form action="{{ route('kadis.surat.preview', $surat->id) }}" method="GET" target="_blank">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" style="background-color: #eeda05ff;">
                                            Preview Surat
                                        </button>
                                    </form>
                                </div>
                            </div>  
                    </div> {{-- Penutup untuk div per surat ($surat) --}}
                    @empty
                        <div class="text-gray-600 dark:text-gray-300">
                            Tidak ada surat yang sudah disetujui superadmin saat ini.
                        </div>
                    @endforelse -->
</x-app-layout>