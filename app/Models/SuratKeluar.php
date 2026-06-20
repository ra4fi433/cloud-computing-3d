<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// model Surat Keluar untuk admin dan superadmin

class SuratKeluar extends Model
{
    protected $fillable = [
        'sifat',
        'perihal',
        'kepada',
        'bidang_id',
        // 'disposisi',
        'isi_surat',
        'tanggal_surat',
        'keterangan',
        'lampiran',
        // hanya untuk kabid dan superadmin
        'status_persetujuan',
        'disetujui_kabid_id',
        'disetujui_kabid_at',
        'disetujui_superadmin_id',
        'disetujui_superadmin_at',
        // hanya untuk superadmin
        'nomor_urut',
        'klasifikasi_surat_id',
        'tanggal_surat',
        // hanya untuk kadis
        'kadis_ttd_status', // <--- BARU
        'kadis_ttd_id',     // <--- BARU
        'kadis_ttd_at',     // <--- BARU
        'dokumen_final_path', // <--- BARU
    ];

   public function klasifikasi()
    {
        return $this->belongsTo(\App\Models\KlasifikasiSurat::class, 'klasifikasi_surat_id');
    }

     // Definisi relasi ke model Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }
    
}
