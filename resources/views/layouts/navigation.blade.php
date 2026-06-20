<nav x-data="{ open: false }" class="border-b border-gray-100" style="background-color: #9c0505;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('documents.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-#004eb5-800" />
                    </a>
                </div>

                <!-- Dashboard landing page -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                    <x-nav-link href="{{ route('dashboard') }}" style="color: #ffffff !important;">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                

                 <!-- {{-- Tombol Lihat Google --}}
                    <button
                        type="button"
                        class="ml-2 border border-[12px] font-bold py-2 px-4 rounded site-preview-button hover:bg-[#28a745] hover:text-white transition"
                        style="color: #28a745; background-color: #ffffff; border-color: #28a745; display: inline-block;"
                        data-site-url="https://www.blackbox.ai/"
                    >
                        Lihat Google
                    </button> -->

                <!-- kabid.surat.index -->
                @if (Auth::check() && Auth::user()->hasAnyRole(['kabid', 'kasubag']))
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                        <x-nav-link href="{{ route('kabid.surat.index') }}" style="color: #ffffff !important;">
                            {{ __('Surat Keluar') }}
                        </x-nav-link>
                    </div>
                @endif

                <!-- documents.index -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                    <x-nav-link href="{{ route('documents.index') }}" style="color: #ffffff !important;">
                        {{ __('Agenda') }}
                    </x-nav-link>
                </div>

                <!-- kadis.surat.index -->
                @if (Auth::check() && Auth::user()->hasRole('Kadis'))
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                        <x-nav-link href="{{ route('kadis.surat.index') }}" style="color: #ffffff !important;">
                            {{ __('Surat Keluar') }}
                        </x-nav-link>
                    </div>
                @endif

                {{-- Gunakan komponen baru Anda --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex text-bold ">
                         <x-site-link-button href="https://e-agendadinas.site/" style="color: #189fffff; !important; font-weight: bold;">
                            {{-- Ganti teks sesuai kebutuhan --}}
                            <strong> Virtual Assistant </strong>
                        </x-site-link-button>
                    </div>
                

            </div>

            <!-- Settings Dropdown -->
        @if (!app()->isDownForMaintenance())
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name ?? 'Guest' }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                         Authentication 
                        @if (Auth::check())
                    
                    @if (Auth::check() && Auth::user()->hasAnyRole(['superadmin', 'admin', 'user']))
                    <x-responsive-nav-link :href="route('filament.admin.pages.dashboard')">
                        {{ "Dashboard"}}
                    </x-responsive-nav-link>
                    @endif
                        <!-- <x-responsive-nav-link :href="route('documents.index')">
                            {{ "Agenda"}}
                        </x-responsive-nav-link>
                        @if (Auth::check() && Auth::user()->hasAnyRole(['kabid', 'kasubag']))
                        <x-responsive-nav-link :href="route('kabid.surat.index')">
                            {{ "Surat keluar"}}
                        </x-responsive-nav-link>
                        @endif
                        @if (Auth::check() && Auth::user()->hasRole('Kadis'))
                        <x-responsive-nav-link :href="route('kadis.surat.index')">
                            {{ "Surat keluar"}}
                        </x-responsive-nav-link>
                        @endif -->

                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ "profile"}}
                    </x-responsive-nav-link>
                @endif
                        <form method="POST" action="{{ route('logout') ?? '#' }}">
                            @csrf
                            <x-dropdown-link :href="route('logout') ?? '#'"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ Auth::check() ? __('Logout') : __('Login') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        @endif

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
     <!-- dashboard -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard') ?? '#'" :active="request()->routeIs('dashboard') ?? false">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
    <!-- daftar agenda -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('documents.index') ?? '#'" :active="request()->routeIs('dashboard') ?? false">
                {{ __('Agenda') }}
            </x-responsive-nav-link>
        </div>

        <!-- konsep surat -->
         @if (Auth::check() && Auth::user()->hasAnyRole(['kabid', 'kasubag']))
         <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('kabid.surat.index') ?? '#'" :active="request()->routeIs('dashboard') ?? false">
                {{ __('Surat keluar') }}
            </x-responsive-nav-link>
        </div>
        @endif
        <!-- surat siap tanda tangan -->
        @if (Auth::check() && Auth::user()->hasRole('Kadis'))
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('kadis.surat.index') ?? '#'" :active="request()->routeIs('dashboard') ?? false">
                    {{ __('Surat keluar') }}
                </x-responsive-nav-link>
            </div>
        </div>
        @endif





        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 " style="background-color: #004eb5;">
            <div class="px-4">
                <div class="font-medium text-base text-white">
                    {{ Auth::user()->name ?? 'Guest' }}
                </div>
                <div class="font-medium text-sm text-white">
                    {{ Auth::user()->email ?? 'No Email' }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                {{-- @if (Auth::check()) --}}
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:text-gray-200">
                    {{ "profile" }}
                </x-responsive-nav-link>
                {{-- @endif --}}
                
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') ?? '#' }}">
                    @csrf
                    <x-responsive-nav-link 
                        :href="route('logout') ?? '#'" 
                        class="text-white hover:text-gray-200"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        {{-- Skrip JavaScript untuk modal --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Karena hanya tombol site-preview-button yang di navigation, kita bisa fokus ke itu
            // Jika ada tombol preview-button di halaman lain, script ini akan tetap menangani keduanya
            const previewButtons = document.querySelectorAll('.preview-button'); // Tetap sertakan jika ada di halaman lain
            const sitePreviewButtons = document.querySelectorAll('.site-preview-button');
            const pdfModal = document.getElementById('pdfModal');
            const pdfIframe = document.getElementById('pdfIframe');
            const closeModalButton = document.getElementById('closeModalButton');
            const modalTitle = pdfModal.querySelector('h3');

            // Logika untuk tombol PDF (tetap dipertahankan jika ada di view lain)
            previewButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const pdfUrl = this.dataset.pdfUrl;
                    pdfIframe.src = pdfUrl;
                    modalTitle.textContent = 'Preview Surat'; // Set judul modal
                    pdfModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });

            // Logika untuk tombol situs
            sitePreviewButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const siteUrl = this.dataset.siteUrl;
                    pdfIframe.src = siteUrl;
                    modalTitle.textContent = 'Lihat Situs Eksternal'; // Set judul modal untuk situs
                    pdfModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });

            // Logika penutup modal
            closeModalButton.addEventListener('click', function () {
                pdfModal.classList.add('hidden');
                pdfIframe.src = '';
                document.body.style.overflow = '';
            });

            pdfModal.addEventListener('click', function (event) {
                if (event.target === pdfModal) {
                    closeModalButton.click();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !pdfModal.classList.contains('hidden')) {
                    closeModalButton.click();
                }
            });
        });
    </script>
@endpush

    </div>
</nav>
