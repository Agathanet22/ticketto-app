@extends('layouts.app')

@section('title', 'Edit Acara')

@section('content')
<div class="container py-4">
    {{-- Judul halaman menjadi dinamis --}}
    <h1>Edit Acara: {{ $event->name }}</h1>
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            {{-- PERBAIKAN: Mengubah $event->id menjadi $event agar menggunakan slug --}}
            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                {{-- Memanggil form partial, mengirim data event dan teks tombol --}}
                @include('admin.events._form', ['event' => $event, 'submitButtonText' => 'Simpan Perubahan'])
            </form>
        </div>
    </div>
</div>
@endsection
