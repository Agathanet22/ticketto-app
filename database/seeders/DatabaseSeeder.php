<?php

namespace Database\Seeders;

use App\Models\User; // Tambahkan ini
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan ini

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Kriteria unik untuk mencari/membuat
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // Password di-hash
                'is_admin' => true, // Set sebagai admin
            ]
        );

        // Buat user biasa (jika ingin user biasa dengan email spesifik)
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        // Panggil EventSeeder dan TicketTypeSeeder
        $this->call([
            EventSeeder::class,
            TicketTypeSeeder::class,
        ]);
    }
}
