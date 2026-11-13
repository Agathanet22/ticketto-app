@extends('layouts.app')

@section('title', 'Detail Acara - ' . $event->name)

@section('content')
<div class="container py-4">
    {{-- Menampilkan pesan sukses atau error setelah mencoba booking --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{ $event->poster ? Storage::url($event->poster) : 'https://placehold.co/600x400/ff914d/ffffff?text=Poster' }}" class="img-fluid rounded-start" alt="Poster {{ $event->name }}" style="object-fit: cover; height: 100%;">
            </div>
            <div class="col-md-8">
                <div class="card-body d-flex flex-column">
                    <h1 class="card-title" style="font-family: 'League Spartan', sans-serif;">{{ $event->name }}</h1>
                    <p class="card-text text-muted">
                        {{ $event->description }}
                    </p>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><i class="fas fa-calendar-alt me-2 text-primary"></i><strong>Tanggal:</strong> {{ $event->date->format('d F Y') }}</li>
                        <li class="list-group-item"><i class="fas fa-clock me-2 text-primary"></i><strong>Waktu:</strong> {{ optional($event->time)->format('H:i') }} WIB</li>
                        <li class="list-group-item"><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Lokasi:</strong> {{ $event->location }}</li>
                    </ul>

                    <h5 class="mt-3">Pesan Tiket Anda</h5>
                    
                    {{-- Mengganti daftar statis menjadi form interaktif --}}
                    <div class="list-group">
                        @forelse ($event->ticketTypes as $type)
                            @if($type->quota > 0)
                            <form action="{{ route('booking.store', $type) }}" method="POST" class="list-group-item">
                                @csrf
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $type->name }}</h6>
                                        <strong class="text-success">Rp {{ number_format($type->price, 0, ',', '.') }}</strong>
                                        <small class="d-block text-muted">Sisa kuota: {{ $type->quota }}</small>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" style="width: 180px;">
                                        <input type="number" name="quantity" class="form-control form-control-sm" value="1" min="1" max="{{ $type->quota }}" required>
                                        <button type="submit" class="btn btn-brand-primary btn-sm">Pesan</button>
                                    </div>
                                </div>
                            </form>
                            @else
                            <div class="list-group-item text-muted">
                                <h6 class="mb-1">{{ $type->name }}</h6>
                                <strong>Habis Terjual</strong>
                            </div>
                            @endif
                        @empty
                        <div class="list-group-item text-center">
                            Belum ada jenis tiket yang dijual untuk acara ini.
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-auto pt-4 d-flex align-items-center">
                        <a href="{{ route('events.index') }}" class="btn btn-brand-secondary btn-back-arrow" title="Kembali ke Daftar Acara">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
