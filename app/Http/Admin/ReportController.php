<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\SalesExport; // Diperlukan untuk export Excel
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf; // Diperlukan untuk export PDF
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // Diperlukan untuk export Excel

class ReportController extends Controller
{
    /**
     * Menampilkan laporan penjualan tiket.
     * Logika ini mengambil data Event, menghitung total tiket terjual,
     * dan total pendapatan berdasarkan data 'sold' di TicketType.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function salesReport(Request $request)
    {
        // Query dasar untuk mengambil semua event, sekaligus memuat jenis tiketnya (eager loading)
        $query = Event::query()->with('ticketTypes');

        // Filter event berdasarkan rentang tanggal yang dipilih (jika ada)
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // Ambil semua event yang sesuai dengan filter
        $events = $query->get();

        $totalRevenue = 0;        // Inisialisasi total pendapatan keseluruhan
        $totalTicketsSold = 0;    // Inisialisasi total tiket terjual keseluruhan

        // Loop melalui setiap event untuk menghitung detail penjualan
        foreach ($events as $event) {
            // Hitung total tiket terjual dan pendapatan untuk event ini
            $eventTotalSold = $event->ticketTypes->sum('sold');
            $eventTotalRevenue = $event->ticketTypes->sum(fn($ticket) => $ticket->sold * $ticket->price);

            // Simpan hasil perhitungan ke properti dinamis pada objek event
            $event->total_sold_tickets = $eventTotalSold;
            $event->total_revenue = $eventTotalRevenue;

            // Tambahkan ke total keseluruhan
            $totalTicketsSold += $eventTotalSold;
            $totalRevenue += $eventTotalRevenue;
        }

        // Kirim data event dan total keseluruhan ke view
        return view('admin.reports.sales', compact('events', 'totalRevenue', 'totalTicketsSold'));
    }

    /**
     * Mengekspor laporan penjualan ke format Excel.
     * Menggunakan class SalesExport yang akan memproses data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(Request $request)
    {
        $fileName = 'laporan-penjualan-' . date('Y-m-d') . '.xlsx';
        // Menggunakan SalesExport class dan mengirimkan filter tanggal
        return Excel::download(new SalesExport($request->start_date, $request->end_date), $fileName);
    }

    /**
     * Mengekspor laporan penjualan ke format PDF.
     * Data diambil dan kemudian di-render ke template PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportPdf(Request $request)
    {
        // Logika untuk mengambil dan menghitung data sama seperti di salesReport
        $query = Event::query()->with('ticketTypes');

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }
        $events = $query->get();

        $totalRevenue = 0;
        $totalTicketsSold = 0;

        foreach ($events as $event) {
            $event->total_sold_tickets = $event->ticketTypes->sum('sold');
            $event->total_revenue = $event->ticketTypes->sum(fn($ticket) => $ticket->sold * $ticket->price);

            $totalTicketsSold += $event->total_sold_tickets;
            $totalRevenue += $event->total_revenue;
        }

        // Muat view template PDF dan kirim data
        $pdf = Pdf::loadView('admin.reports.pdf_template', compact('events', 'totalRevenue', 'totalTicketsSold'));

        // Unduh file PDF
        $fileName = 'laporan-penjualan-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}
