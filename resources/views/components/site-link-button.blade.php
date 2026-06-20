<button
    type="button"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:border-gray-300 focus:outline-none focus:border-gray-700 transition duration-150 ease-in-out font-extrabold site-preview-button']) }} {{-- Tambahkan kembali kelas ini --}}
    data-site-url="{{ $href }}" {{-- Tambahkan data attribute ini --}}
    style="color: #f7e950ff !important; font-weight: extrabold;" {{-- Tambahkan gaya ini --}}
>
    {{ $slot }}
</button>