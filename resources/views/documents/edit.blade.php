<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Agenda') }}
        </h2>
    </x-slot>


    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-6">Edit Dokumen</h2>
            <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT') <!-- Use PATCH method -->

                <!-- Nomor Surat -->
                <div>
                    <label for="no_surat" class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                    <input type="text" id="no_surat" name="no_surat" value="{{ old('no_surat', $document->no_surat) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('no_surat')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Surat -->
                <div>
                    <label for="tanggal_surat" class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                    <input type="date" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $document->tanggal_surat) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('tanggal_surat')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Diterima -->
                <div>
                    <label for="tanggal_diterima" class="block text-sm font-medium text-gray-700">Tanggal Diterima</label>
                    <input type="date" id="tanggal_diterima" name="tanggal_diterima" value="{{ old('tanggal_diterima', $document->tanggal_diterima) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('tanggal_diterima')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Kegiatan -->
                <div>
                    <label for="tanggal_kegiatan" class="block text-sm font-medium text-gray-700">Tanggal Kegiatan</label>
                    <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', $document->tanggal_kegiatan) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('tanggal_kegiatan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Waktu Kegiatan -->
                <div>
                    <label for="waktu_kegiatan" class="block text-sm font-medium text-gray-700">Waktu Kegiatan</label>
                    <input type="time" id="waktu_kegiatan" name="waktu_kegiatan" value="{{ old('waktu_kegiatan', $document->waktu_kegiatan) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('waktu_kegiatan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instansi Pengirim -->
                <div>
                    <label for="instansi_pengirim" class="block text-sm font-medium text-gray-700">Instansi Pengirim</label>
                    <input type="text" id="instansi_pengirim" name="instansi_pengirim" value="{{ old('instansi_pengirim', $document->instansi_pengirim) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('instansi_pengirim')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tempat Kegiatan -->
                <div>
                    <label for="tempat_kegiatan" class="block text-sm font-medium text-gray-700">Tempat Kegiatan</label>
                    <input type="text" id="tempat_kegiatan" name="tempat_kegiatan" value="{{ old('tempat_kegiatan', $document->tempat_kegiatan) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('tempat_kegiatan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Perihal -->
                <div>
                    <label for="perihal" class="block text-sm font-medium text-gray-700">Perihal</label>
                    <textarea id="perihal" name="perihal" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('perihal', $document->perihal) }}</textarea>
                    @error('perihal')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe dimatikan
                <div>
                    <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe</label>
                    <select id="tipe" name="tipe" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="Internal" {{ old('tipe', $document->tipe) == 'Internal' ? 'selected' : '' }}>Internal</option>
                        <option value="External" {{ old('tipe', $document->tipe) == 'External' ? 'selected' : '' }}>External</option>
                    </select>
                    @error('tipe')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> -->

                <!-- Lampiran -->
                <div>
                    <label for="lampiran" class="block text-sm font-medium text-gray-700">Lampiran (JPG/pdf, max 2mb)</label>
                    <input type="file" id="lampiran" name="lampiran"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @if($document->lampiran)
                        <p class="mt-2 text-sm text-gray-600">Current File: <a href="{{ asset('storage/' . $document->lampiran) }}" target="_blank" class="text-blue-600 hover:underline">View</a></p>
                    @endif
                    @error('lampiran')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan', $document->keterangan) }}</textarea>
                    @error('keterangan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Disposisi -->
                <div>
                <label class="block text-sm font-medium text-gray-700">Disposisi</label>
                    <div class="mt-1 space-y-2">
                        @php
                            $options = [
                                "Kepala Dinas",
                                "Sekretariat",
                                "DAFDUK",
                                "CAPIL",
                                "PIAK",
                                "PDIP"
                            ];
                        @endphp
                        @foreach ($options as $option)
                        <div class="flex items-center">
                            <input id="{{ Str::slug($option) }}" type="radio" name="disposisi" value="{{ $option }}" 
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" 
                                {{ old('disposisi', $document->disposisi) == $option ? 'checked' : '' }}>
                            <label for="{{ Str::slug($option) }}" class="ms-2 text-sm font-medium text-gray-900">{{ $option }}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('disposisi')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('documents.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md shadow-sm hover:bg-gray-400">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-black rounded-md shadow-sm hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


</x-app-layout>
