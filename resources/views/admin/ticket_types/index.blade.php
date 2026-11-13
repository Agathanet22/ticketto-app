@extends('layouts.app')

@section('title', 'Kelola Jenis Tiket untuk ' . $event->name)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Kelola Tiket</h1>
            <p class="text-muted mb-0">Untuk acara: <strong>{{ $event->name }}</strong></p>
        </div>
        <div>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Kembali ke Daftar Acara</a>
            {{-- PERBAIKAN: Menggunakan $event, bukan $event->id --}}
            <a href="{{ route('admin.events.ticket-types.create', $event) }}" class="btn btn-primary">Tambah Jenis Tiket</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Tiket</th>
                            <th>Harga (IDR)</th>
                            <th>Kuantitas</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ticketTypes as $ticketType)
                        <tr>
                            <td>{{ $ticketType->name }}</td>
                            <td>{{ number_format($ticketType->price, 0, ',', '.') }}</td>
                            <td>{{ $ticketType->quota }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.ticket-types.edit', $ticketType->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.ticket-types.destroy', $ticketType->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jenis tiket ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada jenis tiket untuk acara ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
