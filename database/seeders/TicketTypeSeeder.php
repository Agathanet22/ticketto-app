<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk Konser Musik Indie Fest 2025
        $indieFest = Event::where('slug', 'konser-musik-indie-fest-2025')->first();
        if ($indieFest) {
            TicketType::firstOrCreate(['event_id' => $indieFest->id, 'name' => 'Regular'], ['price' => 75000, 'quota' => 500, 'sold' => 120]);
            TicketType::firstOrCreate(['event_id' => $indieFest->id, 'name' => 'VIP'], ['price' => 150000, 'quota' => 150, 'sold' => 45]);
        }

        // Data untuk Seminar Teknologi Masa Depan
        $techConf = Event::where('slug', 'seminar-teknologi-masa-depan')->first();
        if ($techConf) {
            TicketType::firstOrCreate(['event_id' => $techConf->id, 'name' => 'Early Bird'], ['price' => 150000, 'quota' => 200, 'sold' => 80]);
            TicketType::firstOrCreate(['event_id' => $techConf->id, 'name' => 'Standard'], ['price' => 200000, 'quota' => 300, 'sold' => 150]);
            TicketType::firstOrCreate(['event_id' => $techConf->id, 'name' => 'Premium'], ['price' => 350000, 'quota' => 100, 'sold' => 30]);
        }

        // Data untuk Sycronize Consert 2025 (Event Baru)
        $sycronizeConsert = Event::where('slug', 'sycronize-consert-2025')->first();
        if ($sycronizeConsert) {
            TicketType::firstOrCreate(['event_id' => $sycronizeConsert->id, 'name' => 'General Admission'], ['price' => 250000, 'quota' => 400, 'sold' => 100]);
            TicketType::firstOrCreate(['event_id' => $sycronizeConsert->id, 'name' => 'VIP Package'], ['price' => 500000, 'quota' => 50, 'sold' => 10]);
        }

        // Data untuk Indie Rock Fest (Event Baru)
        $indieRockFest = Event::where('slug', 'indie-rock-fest')->first();
        if ($indieRockFest) {
            TicketType::firstOrCreate(['event_id' => $indieRockFest->id, 'name' => 'Standard Entry'], ['price' => 150000, 'quota' => 600, 'sold' => 250]);
            TicketType::firstOrCreate(['event_id' => $indieRockFest->id, 'name' => 'Backstage Pass'], ['price' => 300000, 'quota' => 20, 'sold' => 5]);
        }
    }
}
