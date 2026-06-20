<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Detail Agenda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto py-8 px-6">
                    <h1 class="text-3xl font-bold mb-6 text-center">Detail Agenda</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-lg">
                        <div>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">No Surat:</strong> {{ $document->no_surat }}</p>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">Tanggal Surat:</strong> {{ Carbon\Carbon::parse($document->tanggal_surat)->isoFormat('DD MMMM YYYY') }}</p>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">Tanggal Diterima:</strong> {{ Carbon\Carbon::parse($document->tanggal_diterima)->isoFormat('DD MMMM YYYY') }}</p>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">Tanggal Kegiatan:</strong> {{ Carbon\Carbon::parse($document->tanggal_kegiatan)->isoFormat('DD MMMM YYYY') }}</p>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">Waktu Kegiatan:</strong> {{ Carbon\Carbon::parse($document->waktu_kegiatan)->isoFormat('HH:mm') }} WIB</p>
                        </div>
                        <div>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">Instansi Pengirim:</strong> {{ $document->instansi_pengirim }}</p>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">Tempat Kegiatan:</strong> {{ $document->tempat_kegiatan }}</p>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">Perihal:</strong> {{ $document->perihal }}</p>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">Keterangan:</strong> {{ $document->keterangan ?? '-' }}</p>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">Bidang Terkait:</strong>
                                @forelse ($document->bidangs as $bidang)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold px-2.5 py-0.5 rounded-full mr-1 mb-1">
                                        {{ $bidang->nama_bidang }}
                                    </span>
                                @empty
                                    Tidak ada bidang terkait.
                                @endforelse
                            </p>
                            <p class="mb-3"><strong class="font-semibold text-gray-700">Lampiran:</strong>
                                @if ($document->lampiran_path)
                                    <a href="{{ asset('storage/' . $document->lampiran_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                        Unduh Lampiran
                                    </a>
                                @else
                                    Tidak ada lampiran
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('documents.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Kembali ke Daftar Agenda
                        </a>
                        {{-- Tombol Edit diasumsikan ditangani Filament. --}}
                        {{-- Jika ingin tetap ada link edit untuk admin, arahkan ke route Filamentnya --}}
                        {{-- Contoh: @if (Auth::check()) <a href="/admin/documents/{{ $document->id }}/edit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 ml-2">Edit Dokumen (Filament)</a> @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>