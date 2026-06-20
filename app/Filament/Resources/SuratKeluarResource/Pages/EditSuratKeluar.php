<?php

namespace App\Filament\Resources\SuratKeluarResource\Pages;

use App\Filament\Resources\SuratKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;
use App\Models\KlasifikasiSurat;
use App\Models\SuratKeluar;

// app/Filament/Resources/SuratKeluarResource/Pages/EditSuratKeluar.php
// yang digunakan untuk mengedit surat keluar oleh superadmin

class EditSuratKeluar extends EditRecord
{
    protected static string $resource = SuratKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole('superadmin')) {
            return parent::getEloquentQuery()->where('status_persetujuan', 'disetujui_kabid');
        }

        return parent::getEloquentQuery();
    }

    protected function convertToRoman(int $number): string
    {
        $romanMap = [
            1000 => 'M', 900 => 'CM', 500 => 'D', 400 => 'CD', 100 => 'C',
            90 => 'XC', 50 => 'L', 40 => 'XL', 10 => 'X', 9 => 'IX',
            5 => 'V', 4 => 'IV', 1 => 'I'
        ];

        $roman = '';
        foreach ($romanMap as $value => $numeral) {
            while ($number >= $value) {
                $roman .= $numeral;
                $number -= $value;
            }
        }
        return $roman;
    }


    // app/Filament/Resources/SuratKeluarResource/Pages/EditSuratKeluar.php

    protected function beforeSave(): void
    {
       $data = $this->form->getState();

        $klasifikasi = KlasifikasiSurat::find($data['klasifikasi_surat_id']);

        if (
            auth()->user()->hasRole('superadmin') &&
            $this->record->status_persetujuan === 'disetujui_kabid' &&
            $klasifikasi &&
            empty($this->record->nomor_urut)
        ) {
            // Ambil nomor urut terakhir dari surat yang SUDAH DISAHKAN (bukan semua surat)
            $lastNomorUrut = SuratKeluar::whereNotNull('nomor_urut')->max('nomor_urut') ?? 0;
            $newUrut = $lastNomorUrut + 1;

            $this->record->nomor_urut = $newUrut;

            // Dapatkan nomor bulan saat ini
            $bulanAngka = now()->format('n'); // 'n' format untuk bulan tanpa leading zero (1-12)
            // Konversi bulan ke Romawi
            $bulanRomawi = $this->convertToRoman($bulanAngka); // Panggil fungsi baru kita

            $tahun = now()->format('Y');
            $kodeKlasifikasi = $klasifikasi->kode;

            $this->record->nomor_surat = "{$newUrut}/{$kodeKlasifikasi}/{$bulanRomawi}/{$tahun}";
            $this->record->status_persetujuan = 'disetujui_superadmin';
            $this->record->disetujui_superadmin_id = auth()->id();
            $this->record->disetujui_superadmin_at = now();
        }
    }


    // protected function beforeSave(): void
    // {
    //     $data = $this->form->getState();
    //     $klasifikasi = \App\Models\KlasifikasiSurat::find($data['klasifikasi_surat_id']);

    //     // Hanya superadmin dan surat yang telah disetujui kabid
    //     if (
    //         auth()->user()->hasRole('superadmin') &&
    //         $klasifikasi &&
    //         $this->record->status_persetujuan === 'disetujui_kabid' &&
    //         $klasifikasi->kode !== '000'
    //     ) {
    //         // Cek apakah belum punya nomor
    //         if (empty($this->record->nomor_urut) || empty($this->record->nomor_surat)) {
    //             $lastNomorUrut = \App\Models\SuratKeluar::max('nomor_urut') ?? 0;
    //             $this->record->nomor_urut = $lastNomorUrut + 1;

    //             $bulan = now()->format('m');
    //             $tahun = now()->format('Y');
    //             $kodeKlasifikasi = $klasifikasi->kode;
    //             $nomorUrut = $this->record->nomor_urut;

    //             $this->record->nomor_surat = "{$kodeKlasifikasi}/{$nomorUrut}/{$bulan}/{$tahun}";
    //         }
    //     }
    // }


    // protected function beforeSave(): void
    // {
    //     $data = $this->form->getState();
    //     $klasifikasi = \App\Models\KlasifikasiSurat::find($data['klasifikasi_surat_id']);

    //     if (
    //         $klasifikasi &&
    //         $klasifikasi->kode !== '000'
    //         // (empty($this->record->nomor_surat) || $this->record->nomor_surat === 'PENDING')
    //     )   {
    //             $lastNomorUrut = \App\Models\SuratKeluar::max('nomor_urut') ?? 0;
    //             $this->record->nomor_urut = $lastNomorUrut + 1;
    //             $tahun = now()->year;
    //             $kodeKlasifikasi = $klasifikasi->kode;

    //             $oldNoSurat = $this->record->nomor_surat;
    //             $parts = explode('/', $oldNoSurat, 2);
    //             $newNoSurat = $kodeKlasifikasi . '/' . $parts[1];
    //             // dd($newNoSurat);
    //             $this->record->nomor_surat = $newNoSurat;
    //         }
    // }


    protected function afterSave(): void
    {
        $this->record->save(); // memastikan semua perubahan tersimpan
    }  



    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman list
        return $this->getResource()::getUrl('index');
    }
}
