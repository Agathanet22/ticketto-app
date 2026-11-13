@extends('layouts.app')

@section('title', 'Tambah Jenis Tiket')

@section('content')
<div class="container py-4">
    <h1 class="h3">Tambah Jenis Tiket Baru</h1>
    <p class="text-muted">Untuk acara: <strong>{{ $event->name }}</strong></p>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <form action="{{ route('admin.events.ticket-types.store', $event) }}" method="POST">
                @include('admin.ticket_types._form', ['submitButtonText' => 'Tambah Tiket'])
            </form>
        </div>
    </div>
</div>
@endsection
