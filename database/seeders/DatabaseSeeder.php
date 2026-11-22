<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Membuat akun admin, customer, kategori, mobil, booking, dan payment demo.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@rentalmobil.com'],
            [
                'name'     => 'Admin Rental',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer1@example.com'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('customer123'),
                'role'     => 'customer',
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer2@example.com'],
            [
                'name'     => 'Siti Aminah',
                'password' => Hash::make('customer123'),
                'role'     => 'customer',
            ]
        );

        $this->call([
            CategorySeeder::class,
            CarSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
