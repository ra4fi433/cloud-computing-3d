<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlasifikasiSurat extends Model
{
    protected $fillable = ['kode', 'nama', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
