<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Mengambil data Event beserta relasi ticketTypes
        $query = Event::query()->with('ticketTypes');

        // Menerapkan filter tanggal jika ada
        if ($this->startDate) {
            $query->whereDate('date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('date', '<=', $this->endDate);
        }

        return $query->get();
    }

    /**
     * Menentukan judul untuk setiap kolom di file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama Acara',
            'Tanggal',
            'Lokasi',
            'Total Tiket Terjual',
            'Total Pendapatan (IDR)',
        ];
    }

    /**
     * Memetakan data dari setiap baris collection ke format yang diinginkan.
     *
     * @param mixed $event
     * @return array
     */
    public function map($event): array
    {
        // Menghitung total tiket terjual dari semua tipe tiket untuk event ini
        $totalSold = $event->ticketTypes->sum('sold');
        
        // Menghitung total pendapatan dari semua tipe tiket untuk event ini
        $totalRevenue = $event->ticketTypes->sum(function($ticketType) {
            return $ticketType->sold * $ticketType->price;
        });

        return [
            $event->name,
            $event->date->format('d M Y'),
            $event->location,
            $totalSold,
            $totalRevenue, // Mengembalikan sebagai angka agar bisa dijumlahkan di Excel
        ];
    }
}
