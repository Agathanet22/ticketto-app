@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-3">Laporan Penjualan Tiket</h1>

    {{-- Card untuk Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Filter Laporan</h5>
            <p class="card-text text-muted">Pilih rentang tanggal untuk menampilkan atau mengekspor laporan.</p>
            
            <form action="{{ route('admin.reports.sales') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-2">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        {{-- Menggunakan request() helper untuk menjaga nilai input setelah submit --}}
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Terapkan Filter</button>
                        {{-- Atribut 'formaction' mengubah tujuan form untuk tombol spesifik ini --}}
                        <button type="submit" class="btn btn-success me-2" formaction="{{ route('admin.reports.export_excel') }}">
                            <i class="fas fa-file-excel me-1"></i> Export Excel
                        </button>
                        <button type="submit" class="btn btn-danger" formaction="{{ route('admin.reports.export_pdf') }}">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Card untuk Pratinjau Laporan --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            Pratinjau Laporan
            <span class="badge bg-secondary">Total Pendapatan: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Acara</th>
                            <th>Tanggal</th>
                            <th>Tiket Terjual</th>
                            <th class="text-end">Pendapatan (IDR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $event)
                            <tr>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->date->format('d M Y') }}</td>
                                <td>{{ $event->total_sold_tickets }}</td>
                                <td class="text-end">{{ number_format($event->total_revenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data penjualan untuk rentang tanggal yang dipilih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="table-light fw-bold">
                            <td colspan="2">TOTAL KESELURUHAN</td>
                            <td>{{ $totalTicketsSold }}</td>
                            <td class="text-end">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
