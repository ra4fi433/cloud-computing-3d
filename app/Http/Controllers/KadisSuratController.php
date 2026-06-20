<?php


namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\SuratKeluar;
use App\Models\User;
use Dompdf\Dompdf; // Untuk PDF generation (jika pakai Dompdf)
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Barryvdh\DomPDF\Facade\Pdf;

class KadisSuratController extends Controller
{
    //
   
    public function index()
        {
            // Ambil daftar surat keluar yang sudah disetujui superadmin
            // dan belum ditandatangani oleh Kadis.
            // Hanya tampilkan surat yang status persetujuannya 'disetujui_superadmin'
            // dan status tanda tangannya 'belum_ditandatangani' atau sudah ditandatangani oleh Kadis yang sama.
            // Ini untuk memastikan Kadis hanya melihat surat yang relevan untuk ditandatangani.
             $suratList = \App\Models\SuratKeluar::whereIn('status_persetujuan', [
                'disetujui_superadmin',
            // Tambahkan juga status jika Kadis sudah menandatangani agar tetap terlihat
            // 'ditandatangani_elektronik_kadis', // Misalnya jika status ini ada
            // 'ditandatangani_manual_kadis', // Misalnya jika status ini ada
            ])
            // Filter tambahan: Hanya tampilkan surat yang belum ditandatangani Kadis (belum_ditandatangani)
            // ATAU surat yang sudah ditandatangani Kadis oleh Kadis yang sama (untuk riwayat Kadis tersebut)
            ->where(function ($query) {
                $query->where('kadis_ttd_status', 'belum_ditandatangani')
                    ->orWhere('kadis_ttd_id', Auth::id());
            })
            ->orderByDesc('created_at')
            ->get();

            return view('kadis.surat.index', compact('suratList'));
             dd('Berhasil memuat KadisSuratController ini!');
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
    
    /**
     * Menandatangani surat secara elektronik oleh Kadis.
     * Akan generate PDF final dan simpan path-nya.
     */
    public function signElectronic(Request $request, $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        // Pastikan hanya surat yang sudah disetujui superadmin dan belum ditandatangani kadis
        if ($surat->status_persetujuan !== 'disetujui_superadmin' || $surat->kadis_ttd_status !== 'belum_ditandatangani') {
            return back()->with('error', 'Surat tidak dapat ditandatangani secara elektronik.');
        }

        // --- Logic Generate Tanda Tangan Elektronik ---
        // 1. Ambil data Kadis yang login
        $kadis = Auth::user();

        // 2. Generate konten tanda tangan elektronik
        // Ini adalah contoh sederhana. Dalam kasus nyata, Anda mungkin berinteraksi dengan API BSrE
        // untuk mendapatkan QR code atau hash digital yang sebenarnya.
        $logoPemerintahKotaPath = public_path('Logo-kota.png'); // Pastikan path logo benar
        $imageType = pathinfo($logoPemerintahKotaPath, PATHINFO_EXTENSION);
        $imageData = base64_encode(file_get_contents($logoPemerintahKotaPath));
        $logoSrc = 'data:image/' . $imageType . ';base64,' . $imageData;

        // Teks untuk tanda tangan elektronik
        $signatureContentHtml = '
            <div style="text-align: center; border: 1px solid #ccc; padding: 5px; margin-top: 20px;">
                <img src="' . $logoSrc . '" alt="Logo Pemerintah Kota Semarang" style="width: 50px; float: left; margin-right: 10px;">
                <p style="margin: 0;">Dokumen ini telah ditandatangani</p>
                <p style="margin: 0; font-weight: bold;">secara elektronik.</p>
                <div style="clear: both;"></div>
            </div>
            <p style="margin-top: 10px;"><strong>' . $kadis->name . '</strong><br>
            ' . ($kadis->jabatan ?? 'Kepala Dinas') . '<br>
            NIP ' . ($kadis->nip ?? '-') . '</p>
        ';

        // 3. Render HTML surat dengan tambahan tanda tangan elektronik
        // Gunakan view filament.pdf.surat-keluar, lalu inject signatureContentHtml ke dalamnya
        $pdfHtml = view('filament.pdf.surat-keluar', compact('surat'))
                     ->with('signatureContentHtml', $signatureContentHtml) // Kirim HTML tanda tangan
                     ->render();

        // 4. Generate PDF menggunakan Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Penting untuk gambar dari public_path()

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 5. Simpan PDF ke storage
        $fileName = 'surat_' . $surat->nomor_surat . '_signed_electronic.pdf';
        $filePath = 'public/signed_documents/' . $fileName; // Path di storage
        Storage::put($filePath, $dompdf->output());

        // 6. Update status surat di database
        $surat->update([
            'kadis_ttd_status' => 'elektronik',
            'kadis_ttd_id' => $kadis->id,
            'kadis_ttd_at' => now(),
            'dokumen_final_path' => Storage::url($filePath), // Simpan URL yang bisa diakses publik
        ]);

        return back()->with('success', 'Surat berhasil ditandatangani secara elektronik dan PDF final tersimpan.');
    }

    /**
     * Menandatangani surat secara manual/konvensional oleh Kadis.
     * Tidak generate PDF baru, hanya update status.
     */
    public function signManual($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        // Pastikan hanya surat yang sudah disetujui superadmin dan belum ditandatangani kadis
        if ($surat->status_persetujuan !== 'disetujui_superadmin' || $surat->kadis_ttd_status !== 'belum_ditandatangani') {
            return back()->with('error', 'Surat tidak dapat ditandatangani secara manual.');
        }

        $surat->update([
            'kadis_ttd_status' => 'manual',
            'kadis_ttd_id' => Auth::id(),
            'kadis_ttd_at' => now(),
            // dokumen_final_path tidak perlu diisi karena ini akan di-print manual
        ]);

        return back()->with('success', 'Surat berhasil diatur untuk tanda tangan manual. Harap print out hardcopy.');
    }
}
