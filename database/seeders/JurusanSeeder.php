<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = Carbon::now();
        DB::table('jurusans')->insert([
            ['kompetensi_keahlian' => 'Desain Komunikasi Visual', 'created_at' => $now, 'updated_at' => $now],
            ['kompetensi_keahlian' => 'Teknik Kendaraan Ringan Otomotif', 'created_at' => $now, 'updated_at' => $now],
            ['kompetensi_keahlian' => 'Agrobisnis Pengolahan Hasil Pertanian', 'created_at' => $now, 'updated_at' => $now],
            ['kompetensi_keahlian' => 'Teknik Pemesinan', 'created_at' => $now, 'updated_at' => $now],
            ['kompetensi_keahlian' => 'Teknik Pengelasan', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
