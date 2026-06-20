<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bidang_id',
        // 'disposisi',
    ];

    public function getFilamentName(): string
    {
        return $this->name;
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Definisi relasi ke model Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    // Jika Anda memiliki relasi role:
    // public function role()
    // {
    //     return $this->belongsTo(\App\Models\Role::class); // Sesuaikan dengan namespace dan nama model Role Anda
    // }

    // Jika Anda menggunakan Filament, ini akan berguna untuk menampilkan nama user
    // public function getFilamentName(): string
    // {
    //     return $this->name;
    // }
}
