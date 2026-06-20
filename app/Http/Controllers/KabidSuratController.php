<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\SuratKeluar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KabidSuratController extends Controller
{
    //fungsi untuk menampilkan daftar surat yang perlu disetujui oleh Kabid
    // Hanya surat dengan status 'menunggu_kabid' yang akan ditampilkan
    // Kabid dapat menyetujui surat tersebut, yang akan mengubah statusnya menjadi 'disetujui_kabid'
    // Setelah disetujui, surat akan ditampilkan di halaman Kabid Surat
    // Pastikan untuk mengimpor model yang diperlukan seperti SuratKeluar
    public function index()
        {
            // fungsi ini akan mengambil semua surat yang perlu disetujui oleh Kabid
            // $userBidang = Auth::user()->disposisi; // Contoh: Auth::user()->bidang; 

            // 1. Ambil ID bidang dari user (Kabid) yang sedang login
            $userBidangId = Auth::user()->bidang_id;

            // Jika Kabid tidak memiliki bidang terkait (error konfigurasi user)
            if (!$userBidangId) {
                return view('kabid.surat.index', ['suratList' => collect()])
                        ->with('error', 'Akun Anda tidak terhubung dengan bidang manapun. Silakan hubungi Superadmin.');
            }
            // $suratList = SuratKeluar::where('disposisi', $userBidang) // Filter berdasarkan bidang Kabid
            // $suratList =  \App\Models\SuratKeluar::whereIn('status_persetujuan', [
            $suratList = SuratKeluar::where('bidang_id', $userBidangId)
            ->whereIn('status_persetujuan', [
                'menunggu_kabid',       // Masih menunggu persetujuan Kabid
                'disetujui_kabid',      // Sudah disetujui oleh Kabid
                'disetujui_superadmin', // Sudah disetujui oleh Superadmin
                'draft',                // Surat yang ditolak Kabid (karena Anda set jadi 'draft' lagi)
                // Jika ada status penolakan superadmin, tambahkan juga:
                // 'ditolak_superadmin'
            ])
            ->orderByDesc('created_at')
            ->get();

        return view('kabid.surat.index', compact('suratList'));
            // $suratList = SuratKeluar::where('status_persetujuan', 'menunggu_kabid')
            //     ->orderByDesc('created_at')
            //     ->get();

            // return view('kabid.surat.index', compact('suratList'));
        }       

    public function approve($id)
        {
            $surat = SuratKeluar::findOrFail($id);
            $userBidangId = Auth::user()->bidang_id; // Bidang Kabid yang login

            // 1. **Penting**: Verifikasi bahwa surat ini memang berasal dari bidang Kabid yang login
            if ($surat->bidang_id !== $userBidangId) {
                return back()->with('error', 'Anda tidak berhak menyetujui surat dari bidang lain.');
            }

            if ($surat->status_persetujuan !== 'menunggu_kabid') {
                return back()->with('error', 'Surat tidak dalam status yang bisa disetujui.');
            }

            $surat->update([
                'status_persetujuan' => 'disetujui_kabid',
                'disetujui_kabid_id' => Auth::id(),
                'disetujui_kabid_at' => now(),
            ]);

            return back()->with('success', 'Surat berhasil disetujui.');
        }

    public function store(Request $request)
        {
            $validated = $request->validate([
                'sifat' => 'required|string|max:255',
                'perihal' => 'required|string',
                'kepada' => 'required|string',
                'disposisi' => 'nullable|string',
                'isi_surat' => 'required|string',
                // 'tanggal_surat' => 'required|date',
                'keterangan' => 'nullable|string',
                'lampiran' => 'nullable|string',
            ]);

            $validated['status_persetujuan'] = 'menunggu_kabid';

            SuratKeluar::create($validated);

            return redirect()->route('kabid.surat.index')->with('success', 'Surat berhasil dibuat dan menunggu persetujuan Kabid.');
        }

    public function preview($id)
        {
            $surat = SuratKeluar::findOrFail($id);

            // Render Blade view 'filament.pdf.surat-keluar' menjadi PDF
            $pdf = Pdf::loadView('filament.pdf.surat-keluar', [
                'surat' => $surat,
            ]);

            // Mengembalikan PDF sebagai stream, sehingga browser bisa menampilkannya langsung
            // Nama file di sini opsional, tapi membantu browser
            return $pdf->stream('surat-keluar-' . $surat->id . '.pdf'); // Menggunakan $surat->id atau $surat->nomor_urut

            // Jika kamu ingin memaksa unduhan:
            // return $pdf->download('surat-keluar-' . $surat->id . '.pdf');
        }


    // public function preview($id)
    //     {
    //         $surat = SuratKeluar::findOrFail($id);

            
    //         return view('filament.pdf.surat-keluar', compact('surat'));
    //     }
    // Tambahkan fungsi lain sesuai kebutuhan, seperti untuk menolak surat atau mengubah statusnya
    public function reject(Request $request, $id)
    {
        $surat = SuratKeluar::findOrFail($id);
         $userBidangId = Auth::user()->bidang_id;

        // 1. Verifikasi bahwa surat ini memang milik bidang Kabid yang login
        if ($surat->bidang_id !== $userBidangId) {
            return back()->with('error', 'Anda tidak berhak menolak surat dari bidang lain.');
        }

        if ($surat->status_persetujuan !== 'menunggu_kabid') {
            return back()->with('error', 'Surat tidak dalam status yang bisa ditolak.');
        }

        $validated = $request->validate([
            'keterangan' => 'required|string|min:5',
        ]);

        $surat->update([
            'status_persetujuan' => 'draft',
            'keterangan' => $validated['keterangan'],
        ]);

        return back()->with('success', 'Surat ditolak dan dikembalikan ke staf.');
    }

}

