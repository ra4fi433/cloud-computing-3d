<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Surat Masuk') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-6">Tambah Dokumen Baru</h2>
                
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @csrf

                    <!-- Kolom 1 -->
                    <div>
                        <label for="no_surat" class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                        <input type="text" id="no_surat" name="no_surat" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="tanggal_diterima" class="block text-sm font-medium text-gray-700">Tanggal Diterima</label>
                        <input type="date" id="tanggal_diterima" name="tanggal_diterima" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="tempat_kegiatan" class="block text-sm font-medium text-gray-700">Tempat Kegiatan</label>
                        <input type="text" id="tempat_kegiatan" name="tempat_kegiatan" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    

                    <!-- Kolom 2 -->
                    <div>
                        <label for="tanggal_surat" class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                        <input type="date" id="tanggal_surat" name="tanggal_surat" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="instansi_pengirim" class="block text-sm font-medium text-gray-700">Instansi Pengirim</label>
                        <input type="text" id="instansi_pengirim" name="instansi_pengirim" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>


                    <!-- Kolom 3 -->
                    <div>
                        <label for="tanggal_kegiatan" class="block text-sm font-medium text-gray-700">Tanggal Kegiatan</label>
                        <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="lampiran" class="block text-sm font-medium text-gray-700">Lampiran (JPG/pdf, max 2mb)</label>
                        <input type="file" id="lampiran" name="lampiran"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                
                    <div>
                        <label for="perihal" class="block text-sm font-medium text-gray-700">Perihal</label>
                        <input type="text" id="perihal" name="perihal" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    
                    <div>
                        <label for="waktu_kegiatan" class="block text-sm font-medium text-gray-700">Waktu Kegiatan</label>
                        <input type="time" id="waktu_kegiatan" name="waktu_kegiatan" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Baris Tambahan -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div class="md:col-span-2 lg:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Disposisi</label>
                    <div class="mt-1 flex flex-wrap gap-x-8 gap-y-2">
                        <div class="flex items-center ms-4">
                            <input id="kepala-dinas" type="radio" name="disposisi" value="Kepala Dinas" required
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                            <label for="kepala-dinas" class="ms-4 text-sm font-medium text-gray-900">Kepala_Dinas</label>
                        </div>
                        <div class="flex items-center ms-4">
                            <input id="sekretariat" type="radio" name="disposisi" value="Sekretariat"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                            <label for="sekretariat" class="ms-4 text-sm font-medium text-gray-900 gap-10">Sekretariat</label>
                        </div>
                        <div class="flex items-center ms-4">
                            <input id="dafduk" type="radio" name="disposisi" value="DAFDUK"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                            <label for="dafduk" class="ms-4 text-sm font-medium text-gray-900">DAFDUK</label>
                        </div>
                        <div class="flex items-center ms-4">
                            <input id="capil" type="radio" name="disposisi" value="CAPIL"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                            <label for="capil" class="ms-4 text-sm font-medium text-gray-900">CAPIL</label>
                        </div>
                        <div class="flex items-center ms-4">
                            <input id="piak" type="radio" name="disposisi" value="PIAK"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                            <label for="piak" class="ms-4 text-sm font-medium text-gray-900">PIAK</label>
                        </div>
                        <div class="flex items-center ms-4">
                            <input id="pdip" type="radio" name="disposisi" value="PDIP"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                            <label for="pdip" class="ms-2 text-sm font-medium text-gray-900 gap-2">PDIP</label>
                        </div>
                    </div>

                    </div>

                    <!-- Tombol Batal & Simpan -->
                    <span class="mt-6 flex justify-right space-x-8">
                    <div class="mt-6 flex justify-center space-x-8">
                        <div>
                            <span class="mt-6 flex space-x-6">  
                                <a href="{{ route('documents.index') }}"
                                class="px-6 py-2 border border-blue-400 text-gray-700 rounded-md hover:bg-gray-100" style="background-color: #BD0000; color: #fff;">
                                    Batal
                                </a>
                            </span>
                        </div>
                        
                        <div>
                            <span class="mt-6 flex justify-right space-x-6">
                                <button type="submit"
                                class="px-6 py-2 border border-blue-400 text-gray-700 rounded-md hover:bg-gray-100" style="background-color: #3b82f6; color: #fff;">
                                    Simpan
                                </button>
                            </span>
                        </div>
                    </div>
                    </span>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>
