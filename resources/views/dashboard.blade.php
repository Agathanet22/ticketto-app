@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    Dashboard
                </div>
                <div class="card-body">
                    <h5 class="card-title">Selamat Datang, {{ Auth::user()->name }}!</h5>
                    <p class="card-text">Anda telah berhasil login. Silakan lihat acara yang tersedia atau tiket yang sudah Anda miliki.</p>
                    <hr>
                    {{-- PERBAIKAN: Mengganti kelas 'btn-primary' menjadi 'btn-brand-primary' --}}
                    <a href="{{ route('events.index') }}" class="btn btn-brand-primary">Lihat Semua Acara</a>
                    <a href="{{ route('user.tickets') }}" class="btn btn-brand-secondary">Tiket Saya</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
