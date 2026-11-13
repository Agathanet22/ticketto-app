<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'name' => 'Konser Musik Indie Fest 2025',
                'description' => 'Festival musik indie terbaik tahun ini!',
                'long_description' => 'Siapkan dirimu untuk malam penuh melodi dengan band-band indie favoritmu! Acara ini akan menampilkan berbagai genre musik dari musisi lokal dan nasional. Jangan lewatkan pengalaman yang tak terlupakan.',
                'date' => Carbon::parse('2025-07-15'),
                'time' => Carbon::parse('2025-07-15 19:00:00'),
                'location' => 'Gelora Bung Karno, Jakarta',
                'poster' => 'posters/poster-indie-fest.png',
                'banner' => 'banners/banner-indie-fest.png', // Asumsi ini juga .png
                'min_price' => 75000,
            ],
            [
                'name' => 'Seminar Teknologi Masa Depan',
                'description' => 'Bahas tren teknologi terkini dan inovasi masa depan.',
                'long_description' => 'Bergabunglah dengan para pemimpin industri dan inovator untuk mendiskusikan tren terbaru di bidang AI, blockchain, dan teknologi imersif. Pelajari wawasan baru dan perluas jaringan Anda.',
                'date' => Carbon::parse('2025-08-01'),
                'time' => Carbon::parse('2025-08-01 09:00:00'),
                'location' => 'Jakarta Convention Center',
                'poster' => 'posters/poster-tech-conf.png',
                'banner' => 'banners/banner-tech-conf.png', // Asumsi ini juga .png
                'min_price' => 150000,
            ],
            // Event baru 1: Sycronize Consert 2025
            [
                'name' => 'Sycronize Consert 2025',
                'description' => 'Konser yang menyatukan alunan musik harmonis dan visual spektakuler.',
                'long_description' => 'Rasakan pengalaman konser yang imersif dengan perpaduan unik antara musik modern dan efek visual yang memukau. Sycronize Consert akan membawamu ke dimensi baru.',
                'date' => Carbon::parse('2025-09-10'),
                'time' => Carbon::parse('2025-09-10 20:00:00'),
                'location' => 'Istora Senayan, Jakarta',
                'poster' => 'posters/Poster-sycronize-consert.png',
                'banner' => 'banners/Banner-sycronize-consert.png',
                'min_price' => 250000,
            ],
            // Event baru 2: Indie Rock Fest
            [
                'name' => 'Indie Rock Fest',
                'description' => 'Festival musik rock independen yang paling dinanti!',
                'long_description' => 'Berjingkrak bersama band-band rock indie terbaik dari seluruh negeri. Dapatkan energi maksimal dari setiap penampilan yang energik dan lirik yang dalam.',
                'date' => Carbon::parse('2025-10-05'),
                'time' => Carbon::parse('2025-10-05 18:00:00'),
                'location' => 'JIExpo Kemayoran, Jakarta',
                'poster' => 'posters/Poster-Indie-Rock-Fest.png',
                'banner' => 'banners/Banner-Indie-Rock-Fest.png',
                'min_price' => 150000,
            ],
        ];

        foreach ($events as $eventData) {
            Event::firstOrCreate(['slug' => Event::generateSlug($eventData['name'])], $eventData);
        }
    }
}
