<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use App\Models\KlasifikasiSurat;

// use this code file if you want seeder as test data 


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BidangSeeder::class,
            DocumentSeeder::class,
            // UserSeeder::class,
            KlasifikasiSuratSeeder::class,
            SpatieSeeder::class,
        ]);
        // User::factory(10)->create();

        // DB::table('documents')->insert([
        //     [
        //         'no_surat' => '001/INT/2025',
        //         'tanggal_surat' => '2025-01-10',
        //         'tanggal_diterima' => '2025-01-11',
        //         'tanggal_kegiatan' => '2025-01-15',
        //         'waktu_kegiatan' => '09:00:00',
        //         'instansi_pengirim' => 'Kementerian Dalam Negeri',
        //         'tempat_kegiatan' => 'Gedung Serbaguna',
        //         'perihal' => 'Rapat Koordinasi Nasional',
        //         'lampiran_path' => 'documents/001_INT_2025.pdf',
        //         'keterangan' => 'Rapat koordinasi tahunan untuk penyusunan strategi 2025.',
        //         'disposisi' => 'Sekretariat',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'no_surat' => '002/EXT/2025',
        //         'tanggal_surat' => '2025-01-12',
        //         'tanggal_diterima' => '2025-01-13',
        //         'tanggal_kegiatan' => '2025-01-20',
        //         'waktu_kegiatan' => '14:00:00',
        //         'instansi_pengirim' => 'Dinas Pendidikan Kota',
        //         'tempat_kegiatan' => 'Aula Utama Dinas Pendidikan',
        //         'perihal' => 'Sosialisasi Program Pendidikan Digital',
        //         'lampiran_path' => 'documents/002_EXT_2025.pdf',
        //         'keterangan' => 'Undangan resmi untuk membahas program pendidikan digital.',
        //         'disposisi' => 'Pencatatan Sipil',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'no_surat' => '003/EXT/2025',
        //         'tanggal_surat' => '2025-01-14',
        //         'tanggal_diterima' => '2025-01-15',
        //         'tanggal_kegiatan' => '2025-01-25',
        //         'waktu_kegiatan' => '10:00:00',
        //         'instansi_pengirim' => 'Badan Pusat Statistik',
        //         'tempat_kegiatan' => 'Ruang Rapat Utama',
        //         'perihal' => 'Workshop Pemanfaatan Data Statistik',
        //         'lampiran_path' => 'documents/003_EXT_2025.pdf',
        //         'keterangan' => null,
        //         'disposisi' => 'Pemanfaatan Data dan Inovasi Pelayanan',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);

        // DB::table('users')->insert([
        //     [
        //         'name' => 'superadmin',
        //         'email' => 'admin@admin.admin',
        //         'password' => Hash::make('rahasia123'), // password
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]
        // ]);
    }
}
