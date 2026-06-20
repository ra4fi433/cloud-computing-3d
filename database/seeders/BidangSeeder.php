<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidang; // Pastikan model Bidang ada
use Illuminate\Support\Facades\DB;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidangs = [
            'Kepala Dinas',
            'Sekretariat',
            'DAFDUK',
            'CAPIL',
            'PIAK',
            'PDIP',
        ];

        foreach ($bidangs as $bidang) {
            Bidang::firstOrCreate(['nama_bidang' => $bidang]);
        }
    }
}