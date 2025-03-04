<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path file SQL
        $filePath = database_path('sql/dummies.sql');

        // Membaca isi file SQL
        $sql = file_get_contents($filePath);

        // Eksekusi SQL
        DB::unprepared($sql);

        // Tampilkan pesan sukses
        $this->command->info('Dummies content seeded successfully!');
    }
}
