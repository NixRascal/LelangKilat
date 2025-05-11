<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ads')->insert([
            [
                'image_path' => 'ads/banner1.png',
            ],
            [
                'image_path' => 'ads/banner2.png',
            ],
            [
                'image_path' => 'ads/banner3.png',
            ],
        ]);
    }
}
