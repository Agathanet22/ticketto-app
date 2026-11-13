@extends('layouts.app')

@section('title', 'Kelola Acara')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Acara</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Tambah Acara Baru</a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Mempertahankan fitur pencarian dari kode Anda --}}
    <div class="mb-3">
        <input type="text" class="form-control" id="searchInput" placeholder="Cari acara...">
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Acara</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Harga Tiket</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody">
                        @forelse ($events as $event)
                        <tr>
                            <td>{{ $loop->iteration + $events->firstItem() - 1 }}</td>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->date->format('d F Y') }}</td>
                            <td>{{ $event->location }}</td>
                            {{-- Mempertahankan kolom harga tiket --}}
                            <td>Rp {{ number_format($event->min_price, 0, ',', '.') }}</td>
                            <td class="text-end">
                                {{-- Pastikan Anda menggunakan $event, BUKAN $event->id --}}
                                <a href="{{ route('admin.events.ticket-types.index', $event) }}" class="btn btn-sm btn-info">Kelola Tiket</a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data acara.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $events->links() }}
        </div>
    </div>
</div>

{{-- Mempertahankan skrip pencarian Anda --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                let filter = searchInput.value.toLowerCase();
                let rows = document.querySelectorAll('#eventTableBody tr');
                rows.forEach(row => {
                    let text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }
    });
</script>
@endpush
@endsection