<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Daftar Surat Keluar') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Daftar Surat Keluar</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                        Berikut adalah surat-surat keluar yang telah disetujui secara final.
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
                                <strong>No Surat:</strong> {{ $surat->nomor_surat }}<br>
                                <strong>Bidang:</strong> {{ $surat->disposisi }}<br>
                                <strong>Status Persetujuan:</strong> {{ ucfirst(str_replace('_', ' ', $surat->status_persetujuan)) }}<br>
                                <strong>Status Tanda Tangan Kadis:</strong> {{ ucfirst(str_replace('_', ' ', $surat->kadis_ttd_status)) }}
                            </p>

                            {{-- Tampilkan isi surat sebagai teks biasa --}}
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Isi Surat:</label>
                                <div class="mt-4">
                                    {{-- Tombol Preview Surat --}}
                                     <!-- <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Isi Surat:</label> -->
                                        <!-- <div class="mt-4"> -->
                                            <!-- <button
                                                type="button"
                                                class="ml-2 bg-white text-[#004eb5] border-2 border-[#004eb5] font-bold py-2 px-4 rounded preview-button hover:bg-[#004eb5] hover:text-white transition"
                                                style="color: #004eb5; background-color: #ffffff; border-color: #004eb5; display: inline-block;"
                                                data-pdf-url="{{ route('kabid.surat.preview', $surat->id) }}"
                                            >
                                                Preview Surat
                                            </button> -->

                                            <button
                                                type="button"
                                                class="ml-2 border border-[12px] font-bold py-2 px-4 rounded preview-button hover:bg-[#004eb5] hover:text-white transition"
                                                style="color: #004eb5; background-color: #ffffff; border-color: #004eb5; display: inline-block;"
                                                data-pdf-url="{{ route('kadis.surat.preview', $surat->id) }}"
                                            >
                                                Preview Surat
                                            </button>

                                    <!-- <form action="{{ route('kadis.surat.preview', $surat->id) }}" method="GET" target="_blank" style="display: inline-block;">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" style="background-color: #eeda05ff;">
                                            Preview Surat
                                        </button>
                                    </form> -->

                                    {{-- Tombol Tanda Tangan Kadis --}}
                                    @if ($surat->status_persetujuan === 'disetujui_superadmin' && $surat->kadis_ttd_status === 'belum_ditandatangani')
                                        <form action="{{ route('kadis.surat.signElectronic', $surat->id) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                                            @csrf
                                            <button type="submit" class="ml-2 border border-12 font-bold py-2 px-4 rounded preview-button hover:bg-[#004eb5] hover:text-white transition"
                                                style="color: #f9dc5cff; background-color: #004eb5; border-color: #004eb5; border 12px; display: inline-block;">
                                                Tandatangani Elektronik
                                            </button>
                                        </form>

                                        <form action="{{ route('kadis.surat.signManual', $surat->id) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                                            @csrf
                                            <button type="submit" class="ml-2 border border-[12px] font-bold py-2 px-4 rounded preview-button hover:bg-[#004eb5] hover:text-white transition"
                                                style="color: #f4f2f5ff; background-color: #004eb5; border-color: #004eb5; display: inline-block;">
                                                Tandatangani Manual
                                            </button>
                                        </form>
                                    @elseif ($surat->kadis_ttd_status === 'elektronik')
                                        <p class="mt-2 text-sm text-green-700 dark:text-green-400">
                                            Surat ini telah ditandatangani secara elektronik.
                                            <!-- @if ($surat->dokumen_final_path)
                                                <a href="{{ $surat->dokumen_final_path }}" target="_blank" class="text-blue-500 hover:underline ml-2">Lihat Dokumen Final</a>
                                            @endif -->
                                        </p>
                                    @elseif ($surat->kadis_ttd_status === 'manual')
                                        <p class="mt-2 text-sm text-orange-700 dark:text-orange-400">
                                            Surat ini telah diatur untuk tanda tangan manual (print out).
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div> {{-- Penutup untuk div per surat ($surat) --}}
                    @empty
                        <div class="text-gray-600 dark:text-gray-300">
                            Tidak ada surat yang menunggu atau telah ditandatangani oleh Anda saat ini.
                        </div>
                    @endforelse

                </div> {{-- Penutup untuk div class="p-6 border-b border-gray-200" --}}
            </div> {{-- Penutup untuk div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" --}}
        </div> {{-- Penutup untuk div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" --}}

         <!-- // Script untuk menangani klik tombol preview -->
         <div id="pdfModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-7xl h-full max-h-40xl flex flex-col">
                    <!-- <div class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-full h-full max-h-full flex flex-col">  -->
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
    </div> {{-- Penutup untuk div class="py-12" --}}
</x-app-layout>