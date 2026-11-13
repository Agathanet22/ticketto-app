@extends('layouts.app')

@section('title', 'Tiket Saya')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Tiket Saya</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Booking</th>
                            <th>Acara</th>
                            <th>Jenis Tiket</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menggunakan @forelse untuk loop data booking dari controller --}}
                        @forelse ($bookings as $booking)
                        <tr>
                            <td><strong>{{ $booking->booking_code }}</strong></td>
                            <td>
                                <div>{{ $booking->event->name }}</div>
                                <small class="text-muted">{{ $booking->event->date->format('d M Y') }}</small>
                            </td>
                            <td>{{ $booking->ticketType->name }}</td>
                            <td>{{ $booking->quantity }}</td>
                            <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if($booking->status == 'paid')
                                    <span class="badge bg-success">Terbayar</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="mb-1">Anda belum memiliki tiket.</p>
                                <a href="{{ route('events.index') }}" class="btn btn-sm btn-primary">Cari Acara Sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
