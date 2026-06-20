<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Daftar Agenda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8 justify-center">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto py-8">
                    <h1 class="text-2xl font-bold mb-6 flex justify-center text-4xl">
                        Daftar Agenda
                    </h1>

                    <form method="GET" action="{{ route('documents.index') }}" class="mb-6 px-6 py-2">
                        <div class="flex flex-wrap justify-end items-center space-x-4 mb-4 gap-4">
                            <div class="w-full sm:w-48">
                                <label for="bidang_id" class="block text-sm font-bold text-gray-700" style="font-size: 1.25rem; font-weight: bold; px-6 py-2">Bidang</label>
                                <select name="bidang_id" id="bidang_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2 px-3">
                                    <option value="all" {{ $selectedBidangId == 'all' ? 'selected' : '' }}>Semua</option>
                                    @foreach ($bidangs as $bidang)
                                        <option value="{{ $bidang->id }}" {{ $selectedBidangId == $bidang->id ? 'selected' : '' }}>
                                            {{ $bidang->nama_bidang }} {{-- Pastikan 'nama_bidang' adalah kolom yang benar di tabel 'bidangs' --}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full sm:w-48">
                                <label for="tanggal_kegiatan" class="block font-bold text-gray-700" style="font-size: 1.25rem; font-weight: bold; px-6 py-2">Tanggal Kegiatan</label>
                                <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan"
                                    value="{{ $selectedTanggalKegiatan }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2 px-3">
                            </div>
                            <div class="flex flex-wrap justify-center gap-2">
                                <button type="submit"
                                    class="w-full sm:w-48 bg-blue-600 text-white px-4 py-2 text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Terapkan Filter
                                </button>
                                {{-- Link untuk menampilkan agenda hari ini dengan reset filter bidang --}}
                                <a href="{{ url('/documents?bidang_id=all&tanggal_kegiatan=' . now()->toDateString()) }}"
                                    class="w-full sm:w-48 flex-wrap bg-gray-500 text-white px-4 py-2 text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                                    Tampilkan Hari Ini
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive overflow-x-auto shadow-md sm:rounded-lg text-center">
                        <table class="w-full table-auto text-base text-gray-800">
                            <thead class="text-white uppercase" style="background-color: #004eb5;">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    @if (Auth::check())
                                        <th scope="col" class="px-6 py-4">No Surat</th>
                                    @endif
                                    <th scope="col" class="px-6 py-4">Tanggal Kegiatan</th>
                                    <th scope="col" class="px-6 py-4">Waktu Kegiatan</th>
                                    <th scope="col" class="px-6 py-4">Instansi Pengirim</th>
                                    <th scope="col" class="px-6 py-4">Perihal</th>
                                    <th scope="col" class="px-6 py-4">Tempat Kegiatan</th>
                                    <th scope="col" class="px-6 py-4">Disposisi</th> {{-- Kolom baru untuk bidang --}}
                                    <th scope="col" class="px-6 py-4">Keterangan</th>
                                    <th scope="col" class="px-6 py-4">Lampiran</th>
                                    <th scope="col" class="px-6 py-4">Aksi</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documents as $document)
                                    <tr class="border-b border-gray-200 text-base font-medium">
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        @if (Auth::check())
                                            <td class="px-6 py-4">{{ $document->no_surat }}</td>
                                        @endif
                                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($document->tanggal_kegiatan)->isoFormat('DD MMMM YYYY') }}</td>
                                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($document->waktu_kegiatan)->isoFormat('HH:mm') }} WIB</td>
                                        <td class="px-6 py-4">{{ $document->instansi_pengirim }}</td>
                                        <td class="px-6 py-4">{{ $document->perihal }}</td>
                                        <td class="px-6 py-4">{{ $document->tempat_kegiatan }}</td>
                                        <td class="px-6 py-4">
                                            @forelse ($document->bidangs as $bidang)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mr-1 mb-1">
                                                    {{ $bidang->nama_bidang }}
                                                </span>
                                            @empty
                                                -
                                            @endforelse
                                        </td>
                                        <td class="px-6 py-4">{{ $document->keterangan }}</td>
                                        <td class="px-6 py-4">
                                            @if ($document->lampiran_path)
                                                <a href="{{ asset('storage/' . $document->lampiran_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                                    Unduh Lampiran
                                                </a>
                                            @else
                                                Tidak ada lampiran
                                            @endif
                                        </td>
                                       
                                            <td class="px-6 py-4 text-blue-700">
                                                <a href="{{ route('documents.show', $document->id) }}" class="hover:underline">Lihat Detail</a>
                                                {{-- Link Edit dan Delete diasumsikan ditangani Filament. --}}
                                                {{-- Jika ingin tetap ada link edit/delete untuk admin, arahkan ke route Filamentnya --}}
                                                {{-- Contoh: <a href="/admin/documents/{{ $document->id }}/edit" class="text-yellow-600 hover:underline ml-2">Edit</a> --}}
                                            </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::check() ? '11' : '9' }}" class="px-6 py-4 text-center">Tidak ada agenda tersedia untuk kriteria ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>