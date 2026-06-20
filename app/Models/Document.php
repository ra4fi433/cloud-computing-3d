<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'tanggal_kegiatan',
        'waktu_kegiatan',
        'instansi_pengirim',
        'tempat_kegiatan',
        'perihal',
        'tipe',
        'lampiran_path',
        'keterangan',
        'user_id',
        'notifikasi_terkirim',
    ];

    public function user() // Pastikan relasi ini sudah ada dan benar
    {
        return $this->belongsTo(User::class);
    }

    // Definisi relasi many-to-many ke model Bidang
    public function bidangs()
    {
        return $this->belongsToMany(Bidang::class, 'document_bidang', 'document_id', 'bidang_id');
        // Parameter:
        // 1. Bidang::class: Model yang akan dihubungkan
        // 2. 'document_bidang': Nama tabel pivot
        // 3. 'document_id': Foreign key di tabel pivot yang merujuk ke model ini (Document)
        // 4. 'bidang_id': Foreign key di tabel pivot yang merujuk ke model Bidang
    }
}