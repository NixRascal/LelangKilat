<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name'       => 'Apartemen',
                'slug'       => 'apartemen',
                'icon_path'  => 'icons/categories/Apartemen.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Gudang',
                'slug'       => 'gudang',
                'icon_path'  => 'icons/categories/Gudang.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Elektronik',
                'slug'       => 'elektronik',
                'icon_path'  => 'icons/categories/Elektronik.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Kapal',
                'slug'       => 'kapal',
                'icon_path'  => 'icons/categories/Kapal.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Motor',
                'slug'       => 'motor',
                'icon_path'  => 'icons/categories/Motor.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Mobil',
                'slug'       => 'mobil',
                'icon_path'  => 'icons/categories/Mobil.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Hotel & Vila',
                'slug'       => 'hotel-vila',
                'icon_path'  => 'icons/categories/HotelDanVila.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Pabrik',
                'slug'       => 'pabrik',
                'icon_path'  => 'icons/categories/Pabrik.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Ruko',
                'slug'       => 'ruko',
                'icon_path'  => 'icons/categories/Ruko.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Rumah',
                'slug'       => 'rumah',
                'icon_path'  => 'icons/categories/Rumah.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Tanah',
                'slug'       => 'tanah',
                'icon_path'  => 'icons/categories/Tanah.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Lain-Lain',
                'slug'       => 'lain-lain',
                'icon_path'  => 'icons/categories/Lain-Lain.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
