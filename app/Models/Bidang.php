<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bidang',
    ];

   // TAMBAHKAN INI: Relasi one-to-many ke model SuratKeluar
    public function suratKeluars()
    {
        return $this->hasMany(SuratKeluar::class, 'bidang_id');
    }

   // Relasi many-to-many ke model Document
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_bidang', 'bidang_id', 'document_id');
    }
    // Relasi ke user (jika ada)
    public function users()
    {
        return $this->hasMany(User::class, 'bidang_id');
    }
}