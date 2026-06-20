<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKeluar;
use App\Models\Document;
// use Carbon\Carbon; // Pastikan Carbon diimpor untuk tanggal
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SuratKeluarController extends Controller
{
    //
    public function dashboard(){
       $nomorUrutTerakhir = SuratKeluar::max('nomor_urut') ?? 0;

        // Mengambil data kegiatan hari ini dan besok
        $kegiatanHariIni = Document::whereDate('tanggal_kegiatan', Carbon::today())->count();
        $kegiatanBesok = Document::whereDate('tanggal_kegiatan', Carbon::tomorrow())->count();

        // Mengirimkan semua data ke tampilan dashboard
        return view('dashboard', compact('nomorUrutTerakhir', 'kegiatanHariIni', 'kegiatanBesok'));
    }
}
