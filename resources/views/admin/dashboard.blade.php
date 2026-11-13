@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            {{-- Menggunakan nama pengguna yang sedang login --}}
            <h1 class="card-title">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="card-text">Pantau penjualan tiket dan kelola acara di sini.</p>
        </div>
    </div>

    <div class="row mb-4">
        {{-- KARTU INI DIBUAT DAPAT DIKLIK --}}
        <div class="col-md-4">
            <a href="{{ route('admin.events.index') }}" class="text-decoration-none">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Total Acara Aktif</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $eventCount ?? 0 }}</h5>
                        <p class="card-text">Acara yang terdaftar.</p>
                    </div>
                </div>
            </a>
        </div>
        {{-- Kartu ini menggunakan data dinamis dari controller --}}
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Pengguna</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $userCount ?? 0 }}</h5>
                    <p class="card-text">Jumlah pengguna terdaftar.</p>
                </div>
            </div>
        </div>
        {{-- Kartu ini adalah placeholder --}}
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Laporan Penjualan</div>
                <div class="card-body">
                    <h5 class="card-title">Lihat Laporan</h5>
                    <p class="card-text">Ekspor data penjualan.</p>
                    {{-- Tautan ini dinamis menggunakan helper route() --}}
                    <a href="{{ route('admin.reports.sales') }}" class="btn btn-sm btn-light stretched-link">Buka</a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3>Acara Terbaru</h3>
        {{-- TOMBOL INI DITAMBAHKAN UNTUK NAVIGASI YANG JELAS --}}
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-primary">Lihat Semua Acara</a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Acara</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Looping data acara terbaru dari controller --}}
                        @forelse ($recentEvents as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->date->format('d F Y') }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                {{-- Tautan dinamis ke halaman edit --}}
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada acara yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
