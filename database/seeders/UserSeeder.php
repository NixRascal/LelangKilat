<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Bayu',
                'email' => 'bayu@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'USER',
                'profile_photo' => 'profiles/bayu.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Admin Lelang',
                'email' => 'admin@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'ADMIN',
                'profile_photo' => 'profiles/admin.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Rina',
                'email' => 'rina@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'USER',
                'profile_photo' => 'profiles/rina.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Andi',
                'email' => 'andi@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'USER',
                'profile_photo' => 'profiles/andi.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Sinta',
                'email' => 'sinta@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'USER',
                'profile_photo' => 'profiles/sinta.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Rizky',
                'email' => 'rizky@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'USER',
                'profile_photo' => 'profiles/rizky.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Fajar',
                'email' => 'fajar@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'USER',
                'profile_photo' => 'profiles/fajar.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Dewi',
                'email' => 'dewi@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'USER',
                'profile_photo' => 'profiles/dewi.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Ilham',
                'email' => 'ilham@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'USER',
                'profile_photo' => 'profiles/ilham.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Putri',
                'email' => 'putri@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'USER',
                'profile_photo' => 'profiles/putri.jpg',
                'created_at' => now(),
            ],
        ]);
    }
}
