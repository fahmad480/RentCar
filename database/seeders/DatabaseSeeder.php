<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\User;
use \App\Models\Role;
use \App\Models\Car;
use \App\Models\Rent;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory()->create([
            'name' => 'admin',
        ]);

        Role::factory()->create([
            'name' => 'user',
        ]);

        User::factory()->create([
            'name' => 'Faraaz Ahmad Permadi',
            'email' => 'faraazap@gmail.com',
            'password' => bcrypt('password'),
            'address' => 'Kp Cipedung 02/01 Ds Jatisari Kec Kutawaringin Kab Bandung',
            'phone' => '081220749123',
            'drivers_license' => '1234567890',
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Pengguna Satu',
            'email' => 'penggunasatu@gmail.com',
            'password' => bcrypt('password'),
            'address' => 'Jakarta Indonesia',
            'phone' => '081220749123',
            'drivers_license' => '1234567890',
            'role_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'Pengguna Dua',
            'email' => 'penggunadua@gmail.com',
            'password' => bcrypt('password'),
            'address' => 'Bandung Indonesia',
            'phone' => '081220749123',
            'drivers_license' => '1234567890',
            'role_id' => 2,
        ]);

        Car::factory()->create([
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'type' => 'MPV',
            'license_plate' => 'B 1234 ABC',
            'color' => 'Black',
            'year' => '2019',
            'machine_number' => '1234567890',
            'chassis_number' => '1234567890',
            'image' => 'https://www.toyota.astra.co.id//sites/default/files/2023-09/1-avanza-purplish-silver.png',
            'seat' => '7',
            'price' => '200000',
            'status' => 'available',
        ]);

        Car::factory()->create([
            'brand' => 'Toyota',
            'model' => 'Raize',
            'type' => 'SUV',
            'license_plate' => 'B 1234 CBA',
            'color' => 'Blue',
            'year' => '2021',
            'machine_number' => '234567891',
            'chassis_number' => '234567891',
            'image' => 'https://static.wixstatic.com/media/261cbb_b882d5760b944419b0393b72b8af55ee~mv2.png/v1/fill/w_688,h_408,al_c,q_85,enc_auto/261cbb_b882d5760b944419b0393b72b8af55ee~mv2.png',
            'seat' => '5',
            'price' => '150000',
            'status' => 'available',
        ]);

        Car::factory()->create([
            'brand' => 'KIA',
            'model' => 'Carens',
            'type' => 'MPV',
            'license_plate' => 'B 4322 CBA',
            'color' => 'Blue',
            'year' => '2023',
            'machine_number' => '234567891',
            'chassis_number' => '234567891',
            'image' => 'https://imgcdn.oto.com/large/gallery/exterior/20/2641/kia-carens-front-angle-low-view-219945.jpg',
            'seat' => '7',
            'price' => '300000',
            'status' => 'unavailable',
        ]);

        Rent::factory()->create([
            'user_id' => 2,
            'car_id' => 3,
            'date_start' => '2023-10-03',
            'date_end' => '2023-10-05',
            'total_price' => '900000',
            'status' => 'in rental',
        ]);
    }
}
