<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SuratKeluar;
use App\Models\user;

class SuratKeluarPreviewController extends Controller
{
    //
    public function preview($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $pdf = Pdf::loadView('filament.pdf.surat-keluar', [
            'surat' => $surat,
        ]);

        return $pdf->stream('surat-keluar-' . $surat->id . '.pdf');
    }
}
