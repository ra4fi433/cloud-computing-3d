<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\Document;
use App\Models\Bidang; // Import model Bidang untuk filter
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tetap sertakan jika show atau index masih merujuk lampiran

class DocumentController extends Controller
{
    /**
     * Tampilkan daftar agenda dengan filter tanggal kegiatan dan bidang.
     * Menggantikan fungsi 'disposisi' dengan filter 'bidang'.
     */
    public function index(Request $request)
    {
        $bidangs = Bidang::all();

        $query = Document::query();

        if ($request->filled('tanggal_kegiatan')) {
            $query->whereDate('tanggal_kegiatan', $request->tanggal_kegiatan);
        } else {
            $query->whereDate('tanggal_kegiatan', Carbon::today());
        }

        if ($request->filled('bidang_id') && $request->bidang_id !== 'all') {
            $query->whereHas('bidangs', function ($q) use ($request) {
                $q->where('bidangs.id', $request->bidang_id);
            });
        }

        $documents = $query->orderBy('tanggal_kegiatan', 'desc')
                           ->orderBy('waktu_kegiatan', 'asc')
                           ->get();

        return view('documents.index', [
            'documents' => $documents,
            'bidangs' => $bidangs,
            'selectedBidangId' => $request->bidang_id ?? 'all',
            'selectedTanggalKegiatan' => $request->tanggal_kegiatan ?? Carbon::today()->toDateString(),
        ]);
    }

    // public function index(Request $request)
    // {
    //     // Ambil semua data Bidang untuk opsi filter di view
    //     $bidangs = Bidang::all();

    //     // Base query untuk mengambil dokumen
    //     $query = Document::query();

    //     // --- Logika Filter Tanggal Kegiatan ---
    //     // Jika parameter 'tanggal_kegiatan' ada di request
    //     if ($request->filled('tanggal_kegiatan')) {
    //         $query->whereDate('tanggal_kegiatan', $request->tanggal_kegiatan);
    //     } else {
    //         // Jika tidak ada filter tanggal, tampilkan agenda untuk hari ini
    //         $query->whereDate('tanggal_kegiatan', Carbon::today());
    //     }

    //     // --- Logika Filter Bidang ---
    //     // Jika parameter 'bidang_id' ada di request dan nilainya bukan 'all'
    //     if ($request->filled('bidang_id') && $request->bidang_id !== 'all') {
    //         // Filter dokumen yang memiliki relasi dengan bidang_id yang dipilih
    //         $query->whereHas('bidangs', function ($q) use ($request) {
    //             $q->where('bidangs.id', $request->bidang_id);
    //         });
    //     }

    //     // Ambil dokumen yang sudah difilter dan urutkan
    //     // Urutkan berdasarkan tanggal kegiatan (terbaru ke lama) dan waktu kegiatan (awal ke akhir)
    //     $documents = $query->orderBy('tanggal_kegiatan', 'desc')
    //                        ->orderBy('waktu_kegiatan', 'asc')
    //                        ->get();

    //     // Kembalikan view 'documents.index' dengan data dokumen dan data filter
    //     return view('documents.index', [
    //         'documents' => $documents,
    //         'bidangs' => $bidangs, // Kirim daftar bidang ke view untuk dropdown filter
    //         'selectedBidangId' => $request->bidang_id ?? 'all', // Pertahankan pilihan bidang di filter
    //         'selectedTanggalKegiatan' => $request->tanggal_kegiatan ?? Carbon::today()->toDateString(), // Pertahankan pilihan tanggal
    //     ]);
    // }

    /**
     * Tampilkan detail spesifik dari sebuah dokumen.
     */
    public function show(Document $document)
    {
        // Langsung kembalikan view 'documents.show' dengan objek dokumen tunggal
        // Laravel secara otomatis akan mengikat {document} dari route ke objek Document model.
        return view('documents.show', compact('document'));
    }

    /**
     * Metode untuk dashboard.
     * Menghitung jumlah kegiatan hari ini dan besok, lalu mengirimkannya ke tampilan dashboard.
     */
    public function dashboard()
    {
        // Menghitung jumlah dokumen (kegiatan) yang tanggalnya hari ini.
        $kegiatanHariIni = Document::whereDate('tanggal_kegiatan', Carbon::today())->count();

        // Menghitung jumlah dokumen (kegiatan) yang tanggalnya besok.
        $kegiatanBesok = Document::whereDate('tanggal_kegiatan', Carbon::tomorrow())->count();

        // Mengirimkan kedua jumlah tersebut ke tampilan 'dashboard'.
        return view('dashboard', compact('kegiatanHariIni', 'kegiatanBesok'));
    }
    // Metode create, store, edit, update, destroy diasumsikan ditangani oleh Filament
    // dan tidak perlu ada di DocumentController ini jika memang tidak digunakan.
    // Jika route-nya masih ada dan kamu ingin memblokir akses, bisa gunakan:
    // public function create() { abort(404); }
    // public function store(Request $request) { abort(404); }
    // public function edit(Document $document) { abort(404); }
    // public function update(Request $request, Document $document) { abort(404); }
    // public function destroy(Document $document) { abort(404); }
}
// namespace App\Http\Controllers;
// use Illuminate\Support\Carbon;
// use App\Models\Document;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;

// class DocumentController extends Controller
// {
//     /**
//      * Tampilkan daftar semua dokumen. !!!!!! betulkan filter
//      */
//     public function index(Request $request)
//     {
//         // $documents = Document::all();
//         // $today = Carbon::today()->format('Y-m-d'); // Get today's date
//         // $documents = Document::whereDate('tanggal_surat', $today)->get();
//         // return view('documents.index', compact('documents'));

//     // Base query
//     $query = Document::query();

//     // Default filters
//     $defaultDisposisi = 'all'; // Default for 'disposisi'
//     $defaultTanggalKegiatan = null; // Default for 'tanggal_kegiatan'

//     // Get filter values from request or use defaults
//     $disposisi = $request->input('disposisi', $defaultDisposisi);
//     $tanggalKegiatan = $request->input('tanggal_kegiatan', $defaultTanggalKegiatan);


//     // Apply filters if present
//     // if ( $request->tipe !== 'all') {
//     //     $query->where('tipe', $request->tipe);
//     // }

//     if ( $request->disposisi !== 'all') {
//         $query->where('disposisi', $request->disposisi);
//     }

//     // Apply Date filter
//     if ($request->tanggal_kegiatan != null) {
//         // $today = Carbon::today()->format('Y-m-d'); // Today's date
//         // $documents = Document::whereDate('tanggal_surat', $today)->get();
//         $query->whereDate('tanggal_kegiatan', $request->tanggal_kegiatan);

//     } else {
//         // Default to showing today's documents if no date filter is provided
//         $query->whereDate('tanggal_kegiatan', Carbon::today());
//     }

//     // $documents = $query->where('tanggal_kegiatan', '>=', Carbon::now()->subDays(7));
//     // dd($documents);
//      // Get the filtered documents
//     $documents = $query->orderBy('tanggal_kegiatan', 'desc')->get();
//     // $today = Carbon::today()->format('Y-m-d'); // Today's date
//     // $documents = Document::whereDate('tanggal_surat', $today)->get();
//      // If no specific filter is applied, show today's documents
//     if (!$request->filled('tanggal_kegiatan') && $request->disposisi === 'all') {
//         $today = Carbon::today()->format('Y-m-d');
//         $documents = Document::whereDate('tanggal_surat', $today)->get();
//     }


//     // Pass filters back to the view for the form
//     return view('documents.index', [
//         'documents' => $documents,
//         'selectedTipe' => $request->tipe ?? 'all',
//         'selectedDisposisi' => $request->disposisi ?? 'all',
//         'selectedTanggalKegiatan' => $request->tanggal_kegiatan ?? '',
//         // 'selectedTipe' => $request->tipe,
//         // 'selectedDisposisi' => $request->disposisi,
//         // 'selectedTanggalKegiatan' => $request->tanggal_kegiatan,
//     ]);
//     }

//     /**
//      * Tampilkan form untuk membuat dokumen baru.
//      */
//     public function create()
//     {
//         return view('documents.create');
//     }

//     /**
//      * Simpan dokumen baru ke database.
//      */
//     public function store(Request $request)
//     {
//         $validatedData = $request->validate([
//             'no_surat' => 'required|string|max:255',
//             'tanggal_surat' => 'required|date',
//             'tanggal_diterima' => 'required|date',
//             'tanggal_kegiatan' => 'required|date',
//             'waktu_kegiatan' => 'required|date_format:H:i:s', // Menggunakan format H:i:s
//             'instansi_pengirim' => 'required|string|max:255',
//             'tempat_kegiatan' => 'required|string|max:255',
//             'perihal' => 'required|string|max:255',
//             'lampiran' => 'required|file|mimes:jpg,pdf|max:2048',
//             'keterangan' => 'nullable|string',
//             'disposisi' => 'required|in:Kepala Dinas,Sekretariat,DAFDUK,CAPIL,PIAK,PDIP',
//         ]);

//         $userId = Auth::id();

//         // Upload file lampiran
//         // $lampiranPath = $request->file('lampiran')->store('documents', 'public');
//         if ($request->hasFile('lampiran')) {
//             $lampiranPath = $request->file('lampiran')->store('documents', 'public');
//         } else {
//             $lampiranPath = null; // atau default value jika perlu
//         }
        

//         // Simpan data ke database
//         Document::create([
//             'no_surat' => $request->no_surat,
//             'tanggal_surat' => $request->tanggal_surat,
//             'tanggal_diterima' => $request->tanggal_diterima,
//             'tanggal_kegiatan' => $request->tanggal_kegiatan,
//             'waktu_kegiatan' => $request->waktu_kegiatan,
//             'instansi_pengirim' => $request->instansi_pengirim,
//             'tempat_kegiatan' => $request->tempat_kegiatan,
//             'perihal' => $request->perihal,
//             'lampiran_path' => $lampiranPath,
//             'keterangan' => $request->keterangan,
//             'disposisi' => $request->disposisi,
//             'user_id' => $userId,
//         ]);

//         // dd($request->all());

//         return redirect()->route('documents.index')->with('success', 'Dokumen berhasil ditambahkan!');
//     }

//     /**
//      * Tampilkan detail dokumen.
//      */
//     public function show(Document $document)
//     {
//         $documents = Document::all();
//         return view('documents.show', compact('documents'));
//     }

//     /**
//      * Tampilkan form untuk mengedit dokumen.
//      */
//     public function edit(Document $document)
//     {
//         // $document = Document::find($document);
//         // return $document;
//         return view('documents.edit', compact('document'));
//     }

//     // public function edit($id)
//     // {
//     //     $document = Document::findOrFail($id);
//     //     return view('documents.edit', compact('document'));
//     // }


//     /**
//      * Update dokumen di database.
//      */
//     public function update(Request $request, Document $document)
//     {
//         $request->validate([
//             'no_surat' => 'required|string|max:255',
//             'tanggal_surat' => 'required|date',
//             'tanggal_diterima' => 'required|date',
//             'tanggal_kegiatan' => 'required|date',
//             'waktu_kegiatan' => 'required|string',
//             // 'waktu_kegiatan' => '00:00:00',
//             // 'waktu_kegiatan' => ['required', 'regex:/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/'],
//             'instansi_pengirim' => 'required|string|max:255',
//             'tempat_kegiatan' => 'required|string|max:255',
//             'perihal' => 'required|string|max:255',
//             // 'tipe' => 'required|in:internal,external',
//             'lampiran' => 'nullable|file|mimes:jpg,pdf|max:2048',
//             'keterangan' => 'nullable|string',
//             'disposisi' => 'required|in:Kepala Dinas,Sekretariat,Pendaftaran Penduduk,Pencatatan Sipil,Pengelolaan Informasi Administrasi Kependudukan,Pemanfaatan Data dan Inovasi Pelayanan',
//         // ], [
//         //     'waktu_kegiatan.regex' => 'The time must be in the format HH:MM (24-hour time).',
//         ]);


//         // Upload file lampiran jika ada
//         if ($request->hasFile('lampiran')) {
//             // Hapus file lama
//             Storage::disk('public')->delete($document->lampiran_path);

//             // Simpan file baru
//             $document->lampiran_path = $request->file('lampiran')->store('documents', 'public');
//         }

//         // Update data di database
//         $document->update($request->only([
//             'no_surat',
//             'tanggal_surat',
//             'tanggal_diterima',
//             'tanggal_kegiatan',
//             'waktu_kegiatan',
//             'instansi_pengirim',
//             'tempat_kegiatan',
//             'perihal',
//             // 'tipe',
//             'keterangan',
//             'disposisi',
//         ]));

//         return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui!');
//     }

//     /**
//      * Hapus dokumen dari database.
//      */
//     public function destroy(Document $document)
//     {
//         if ($document->lampiran) {
//             Storage::disk('public')->delete($document->lampiran);
//         }        

//         // Hapus data
//         $document->delete();

//         return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus!');
//     }
// }
