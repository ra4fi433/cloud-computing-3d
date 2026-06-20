<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="container mx-auto py-8">
    <h1 class="text-xl font-bold mb-6">Daftar Dokumen</h1>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No Surat</th>
                    <th scope="col" class="px-6 py-3">Tanggal Surat</th>
                    <th scope="col" class="px-6 py-3">Instansi Pengirim</th>
                    <th scope="col" class="px-6 py-3">Perihal</th>
                    <th scope="col" class="px-6 py-3">Tipe</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documents as $document)
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $document->no_surat }}</td>
                    <td class="px-6 py-4">{{ $document->tanggal_surat }}</td>
                    <td class="px-6 py-4">{{ $document->instansi_pengirim }}</td>
                    <td class="px-6 py-4">{{ $document->perihal }}</td>
                    <td class="px-6 py-4">{{ ucfirst($document->tipe) }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('documents.show', $document->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                        <a href="{{ route('documents.edit', $document->id) }}" class="text-yellow-600 hover:underline mx-2">Edit</a>
                        <!-- <form action="{{ route('documents.destroy', $document->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus dokumen ini?')">Hapus</button>
                        </form> -->
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center">Tidak ada dokumen tersedia.</td>
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

