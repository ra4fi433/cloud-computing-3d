<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Konsep Surat Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Daftar Surat Keluar </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                        Berikut adalah surat-surat keluar yang menunggu persetujuan dari Anda sebagai Kabid.
                    </p>

                    {{-- Notifikasi --}}
                    @if(session('success'))
                        <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-200 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

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
                                    <button
                                                type="button"
                                                class="ml-2 border border-[12px] font-bold py-2 px-4 rounded preview-button hover:bg-[#004eb5] hover:text-white transition"
                                                style="color: #004eb5; background-color: #ffffff; border-color: #004eb5; display: inline-block;"
                                                data-pdf-url="{{ route('kabid.surat.preview', $surat->id) }}"
                                            >
                                                Preview Surat
                                            </button>
                                    <!-- <form action="{{ route('kabid.surat.preview', $surat->id) }}" method="GET" target="_blank">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" style="background-color: #004eb5;">
                                            Preview Surat
                                        </button>
                                    </form> -->
                                </div>
                        </div>  
                        <!-- acc/reject button -->
                         {{-- Logika Kondisional untuk Tombol Aksi --}}
        @if ($surat->status_persetujuan === 'menunggu_kabid')
            <form action="{{ route('kabid.surat.approve', $surat->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded" style="background-color: #004eb5;">
                    Setujui Konsep Surat
                </button>
            </form>
            <form action="{{ route('kabid.surat.reject', $surat->id) }}" method="POST" class="mt-2">
                @csrf
                @method('PUT')
                <div class="mb-2">
                    <label for="keterangan_{{ $surat->id }}" class="block text-sm font-medium">Alasan Penolakan:</label>
                    <textarea name="keterangan" id="keterangan_{{ $surat->id }}" rows="3" required class="w-full rounded border-gray-300"></textarea>
                </div>
                <button class="btn btn-danger mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded" type="submit" style="background-color: #9c0505;">
                    Tolak Konsep Surat
                </button>
            </form>
        @else
            {{-- Pesan opsional jika sudah tidak menunggu persetujuan --}}
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">
                Surat ini berstatus: <strong class="text-blue-600 dark:text-blue-400">{{ ucfirst(str_replace('_', ' ', $surat->status_persetujuan)) }}</strong>
                @if ($surat->status_persetujuan === 'draft') {{-- Karena Anda menolak ke 'draft' --}}
                    <br>Alasan Penolakan: {{ $surat->keterangan ?? '-' }}
                @endif
            </p>
        @endif
                            <!-- <form action="{{ route('kabid.surat.approve', $surat->id) }}" method="POST" >
                                @csrf
                                @method('PUT')
                                <button type="submit" class="mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded" style="background-color: #004eb5;">
                                    Setujui Konsep Surat
                                </button>
                            </form>
                            <form action="{{ route('kabid.surat.reject', $surat->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-2">
                                    <label for="keterangan_{{ $surat->id }}" class="block text-sm font-medium">Alasan Penolakan:</label>
                                    <textarea name="keterangan" id="keterangan_{{ $surat->id }}" rows="3" required class="w-full rounded border-gray-300"></textarea>
                                </div>

                                <button class="btn btn-danger mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded" type="submit" style="background-color: #9c0505;">
                                    Tolak Konsep Surat
                                </button>
                            </form> -->

                        </div>
                    @empty
                        <div class="text-gray-600 dark:text-gray-300">
                            Tidak ada surat yang menunggu persetujuan saat ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- // Script untuk menangani klik tombol preview -->
         <div id="pdfModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden flex items-center justify-center z-50">
                <!-- <div class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-4xl max-h-[90vh] flex flex-col"> -->
                    <div class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-full h-full max-h-full flex flex-col">
                    <div class="flex justify-between items-center p-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Preview Surat</h3>
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

            <script>
        document.addEventListener('DOMContentLoaded', function () {
            const previewButtons = document.querySelectorAll('.preview-button');
            const pdfModal = document.getElementById('pdfModal');
            const pdfIframe = document.getElementById('pdfIframe');
            const closeModalButton = document.getElementById('closeModalButton');

            previewButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const pdfUrl = this.dataset.pdfUrl; // Ambil URL dari data-pdf-url
                    pdfIframe.src = pdfUrl; // Set src iframe
                    pdfModal.classList.remove('hidden'); // Tampilkan modal
                    document.body.style.overflow = 'hidden'; // Nonaktifkan scrolling body
                });
            });

            closeModalButton.addEventListener('click', function () {
                pdfModal.classList.add('hidden'); // Sembunyikan modal
                pdfIframe.src = ''; // Bersihkan src iframe untuk menghentikan loading/memori
                document.body.style.overflow = ''; // Aktifkan kembali scrolling body
            });

            // Tutup modal jika klik di luar area modal (backdrop)
            pdfModal.addEventListener('click', function (event) {
                if (event.target === pdfModal) {
                    closeModalButton.click(); // Panggil fungsi tutup modal
                }
            });

            // Tutup modal jika menekan tombol ESC
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !pdfModal.classList.contains('hidden')) {
                    closeModalButton.click();
                }
            });
        });
    </script>
        <!-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                const previewButtons = document.querySelectorAll('.preview-button');
                previewButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const pdfUrl = this.getAttribute('data-pdf-url');
                        window.open(pdfUrl, '_blank');
                    });
                });
            });
        </script> -->
    </div>
</x-app-layout>
