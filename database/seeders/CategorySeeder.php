<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Apartemen', 'icon_path' => 'icons/categories/Apartemen.png'],
            ['name' => 'Gudang', 'icon_path' => 'icons/categories/Gudang.png'],
            ['name' => 'Elektronik', 'icon_path' => 'icons/categories/Elektronik.png'],
            ['name' => 'Kapal', 'icon_path' => 'icons/categories/Kapal.png'],
            ['name' => 'Motor', 'icon_path' => 'icons/categories/Motor.png'],
            ['name' => 'Mobil', 'icon_path' => 'icons/categories/Mobil.png'],
            ['name' => 'Hotel & Vila', 'icon_path' => 'icons/categories/HotelDanVila.png'],
            ['name' => 'Pabrik', 'icon_path' => 'icons/categories/Pabrik.png'],
            ['name' => 'Ruko', 'icon_path' => 'icons/categories/Ruko.png'],
            ['name' => 'Rumah', 'icon_path' => 'icons/categories/Rumah.png'],
            ['name' => 'Tanah', 'icon_path' => 'icons/categories/Tanah.png'],
            ['name' => 'Lain-Lain', 'icon_path' => 'icons/categories/Lain-Lain.png'],
        ];
        
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'icon_path' => $category['icon_path'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }        
    }
}
