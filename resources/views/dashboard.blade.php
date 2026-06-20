<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight ">
            {{ __('Landing Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <!-- ucapan selamat datang -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center" style="font-size: 2rem; font-weight: bold; diplay: inline-block;">
                    <h3>
                             {{ __("Selamat Datang Di E-Agenda") }}
                    </h3>
                    <h4>
                             {{ __("Dinas Kependudukan dan Pencatatan Sipil Kota Semarang") }}
                    </h4>
                </div>

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 20px; margin-bottom: 20px;">
                    {{-- Menggunakan Tailwind CSS grid untuk membuat 3 kolom sejajar di layar desktop ke atas.
                    Di layar mobile (default), kartu akan tersusun secara vertikal. --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Kartu: Nomor Urut Surat -->
                            <div class="bg-[#004eb5] overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #004eb5;">
                                    <div class="p-6">
                                        <h3 class="text-xl font-bold text-white mb-2 text-left">
                                            {{ __("Nomor Urut Surat") }}
                                        </h3>
                                        {{-- Tampilkan nomor urut terakhir di sini --}}
                                        <div class="text-center text-4xl font-extrabold text-white mt-4">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2 text-center text-blue-600 " style="font-size: 2rem; font-weight: bold; color: #fed324;">
                                                {{-- Tampilkan nomor urut terakhir --}}
                                                {{ $nomorUrutTerakhir ?? '0' }}
                                            </h3>
                                        </div>
                                    </div>
                            </div>
                        <!-- Kartu: Jumlah Surat keluar -->

                        <!-- Kartu: Kegiatan Hari Ini -->
                            <div class="border border-4px bg-white overflow-hidden shadow-sm sm:rounded-lg" style=" border-color: #004eb5;">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-[#004eb5] mb-2 text-left" style="color: #004eb5; font-weight: bold;">
                                        {{ __("Kegiatan Hari Ini") }}
                                    </h3>
                                    <div class="text-center text-4xl font-extrabold text-[#fed324] mt-4"style="font-size: 2rem; font-weight: bold; color: #fed324ff;">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center text-blue-600 " style="font-size: 2rem; font-weight: bold; color: #004eb5;">
                                            {{-- Tampilkan jumlah kegiatan hari ini --}}
                                            {{ $kegiatanHariIni }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        <!-- Kartu: Jumlah Surat Masuk -->

                        <!-- Kartu: Kegiatan Besok -->
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #004eb5;">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-[#004eb5] mb-2 text-left" style="color: #ffffffff; font-weight: bold;">
                                        {{ __("Kegiatan Besok") }}
                                    </h3>
                                    <div class="text-center text-4xl font-extrabold text-white mt-4">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center text-blue-600 " style="font-size: 2rem; font-weight: bold; color: rgba(255, 255, 255, 1);">
                                            {{-- Tampilkan jumlah kegiatan besok --}}
                                            {{ $kegiatanBesok }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        <!-- Kartu: Jumlah Surat Masuk -->
                    </div>
                </div>
            </div>
            <!-- selamat-datang -->   
        </div>                 
    </div>
                    
                    
    </div>
    <!-- ucapan selamat datang -->

        
        </div>
                <!-- <div class="p-6 text-center text-gray-700" style="font-size: 1.5rem;">
                    {{ __("Silahkan uji fitur lainnya") }}
                </div>

                <div class="p-6 text-center text-gray-500" style="font-size: 1.2rem;">
                    {{ __("Terima kasih atas kesabaran Anda.") }}
                </div> -->
            </div>
        </div>
    </div>

    <!-- Uncomment this section if you want to add a link to the dashboard -->
    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center" style="font-size: 2rem; font-weight: bold;">
                        {{ __("Selamat Datang Di E-Agenda Dinas Kependudukan dan Pencatatan Sipil Kota Semarang") }}
                    </div>

                    <div class="p-6 text-center" style="font-size: 2rem; font-weight: bold; color: #004eb5; ">
                         <a href="{{ route('documents.index') }}" class="">
                            {{ __("menuju Dashboard") }}
                        </a>
                    </div>
            </div>
        </div>
    </div> -->
</x-app-layout>
