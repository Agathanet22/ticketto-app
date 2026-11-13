@extends('layouts.app')

@section('title', 'Edit Jenis Tiket')

@section('content')
<div class="container py-4">
    <h1 class="h3">Edit Jenis Tiket</h1>
    <p class="text-muted">Untuk acara: <strong>{{ $ticketType->event->name }}</strong></p>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <form action="{{ route('admin.ticket-types.update', $ticketType->id) }}" method="POST">
                @method('PUT')
                @include('admin.ticket_types._form', ['ticketType' => $ticketType, 'submitButtonText' => 'Simpan Perubahan'])
            </form>
        </div>
    </div>
</div>
@endsection
