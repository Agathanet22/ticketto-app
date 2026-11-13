<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\SalesExport;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $query = Event::query()->with('ticketTypes');

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $events = $query->get();

        // **PERBAIKAN: Inisialisasi variabel di luar loop**
        $totalRevenue = 0;
        $totalTicketsSold = 0;

        foreach ($events as $event) {
            $event->total_sold_tickets = $event->ticketTypes->sum('sold');
            $event->total_revenue = $event->ticketTypes->sum(fn($ticket) => $ticket->sold * $ticket->price);

            $totalTicketsSold += $event->total_sold_tickets;
            $totalRevenue += $event->total_revenue;
        }

        // Variabel ini sekarang dijamin ada, bahkan jika $events kosong
        return view('admin.reports.sales', compact('events', 'totalRevenue', 'totalTicketsSold'));
    }

    public function exportExcel(Request $request)
    {
        $fileName = 'laporan-penjualan-' . date('Y-m-d') . '.xlsx';
        return Excel::download(new SalesExport($request->start_date, $request->end_date), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $query = Event::query()->with('ticketTypes');

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }
        $events = $query->get();

        // **PERBAIKAN: Inisialisasi variabel di luar loop**
        $totalRevenue = 0;
        $totalTicketsSold = 0;

        foreach ($events as $event) {
            $event->total_sold_tickets = $event->ticketTypes->sum('sold');
            $event->total_revenue = $event->ticketTypes->sum(fn($ticket) => $ticket->sold * $ticket->price);

            $totalTicketsSold += $event->total_sold_tickets;
            $totalRevenue += $event->total_revenue;
        }
        
        $pdf = Pdf::loadView('admin.reports.pdf_template', compact('events', 'totalRevenue', 'totalTicketsSold'));
        
        $fileName = 'laporan-penjualan-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}
