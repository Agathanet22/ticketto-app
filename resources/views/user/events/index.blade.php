@extends('layouts.app')

@section('title', 'Daftar Acara')

@section('content')
<div class="page-header-container d-flex justify-content-between align-items-center mt-4 mb-5 mt-5">
    <h1 class="page-header-title">Upcoming Events</h1>
    <form class="d-none d-md-flex content-search-form" action="{{ route('events.index') }}" method="GET">
        <input type="text" class="form-control content-search-input" name="search" placeholder="Search events..." value="{{ request('search') }}">
        <button type="submit" class="btn content-search-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.085.12c.07.109.125.196.242.372l3.91 3.91a1 1 0 0 0 1.414-1.414zM6.5 10a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7"/>
            </svg>
        </button>
    </form>
</div>

<div class="row" id="userEventList">
    @forelse ($events as $event)
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        {{-- Menggunakan $event karena route key sudah diatur ke 'slug' di Model --}}
        <a href="{{ route('events.show', $event) }}" class="card-link-wrapper">
            <div class="card shadow-sm h-100">
                <img src="{{ $event->poster ? Storage::url($event->poster) : 'https://placehold.co/600x400' }}" class="card-img-top" alt="{{ $event->name }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $event->name }}</h5>
                    <p class="card-text text-muted small">{{ $event->location }}</p>
                    <p class="mb-0">{{ optional($event->date)->format('d F Y') }}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <p class="event-price mb-0">IDR {{ number_format($event->min_price, 0, ',', '.') }}</p>
                        <span class="event-availability">Tiket Tersedia</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-12">
        <p class="text-center">Tidak ada acara yang ditemukan.</p>
    </div>
    @endforelse
</div>

{{-- Menambahkan kembali Paginasi --}}
<div class="d-flex justify-content-center mt-4">
    {{ $events->links() }}
</div>


{{-- BAGIAN KOTA TELAH DIPERBAIKI --}}
<div class="city-events-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Find Events in Your City!</h2>
        <div class="navigation-arrows">
            <button class="arrow-btn" id="scrollLeftBtn">&lt;</button>
            <button class="arrow-btn" id="scrollRightBtn">&gt;</button>
        </div>
    </div>
    <div class="city-cards-container" id="cityCardsContainer">
        {{-- Card Kota: Jakarta --}}
        <div class="city-card-new" style="background-image: url('{{ asset('images/cities/jkt.jpg') }}'); --overlay-color: rgba(255, 181, 5, 0.6); --border-color: #ffb505;">
            <a href="{{ route('events.index', ['search' => 'Jakarta']) }}" class="city-card-link-new">
                <span class="city-card-name-new">Jakarta</span>
            </a>
        </div>
        {{-- Card Kota: Malang --}}
        <div class="city-card-new" style="background-image: url('{{ asset('images/cities/jkt.jpg') }}'); --overlay-color: rgba(255, 87, 34, 0.6); --border-color: #ff5722;">
            <a href="{{ route('events.index', ['search' => 'Malang']) }}" class="city-card-link-new">
                <span class="city-card-name-new">Malang</span>
            </a>
        </div>
        {{-- Card Kota: Surabaya --}}
        <div class="city-card-new" style="background-image: url('{{ asset('images/cities/jkt.jpg') }}'); --overlay-color: rgba(3, 169, 244, 0.6); --border-color: #03a9f4;">
            <a href="{{ route('events.index', ['search' => 'Surabaya']) }}" class="city-card-link-new">
                <span class="city-card-name-new">Surabaya</span>
            </a>
        </div>
        {{-- Card Kota: Bandung --}}
        <div class="city-card-new" style="background-image: url('{{ asset('images/cities/jkt.jpg') }}'); --overlay-color: rgba(255, 64, 129, 0.6); --border-color: #ff4081;">
            <a href="{{ route('events.index', ['search' => 'Bandung']) }}" class="city-card-link-new">
                <span class="city-card-name-new">Bandung</span>
            </a>
        </div>
        {{-- Card Kota: Yogyakarta --}}
        <div class="city-card-new" style="background-image: url('{{ asset('images/cities/jkt.jpg') }}'); --overlay-color: rgba(76, 175, 80, 0.6); --border-color: #4caf50;">
            <a href="{{ route('events.index', ['search' => 'Yogyakarta']) }}" class="city-card-link-new">
                <span class="city-card-name-new">Yogyakarta</span>
            </a>
        </div>
        {{-- Card Kota: Semarang --}}
        <div class="city-card-new" style="background-image: url('{{ asset('images/cities/jkt.jpg') }}'); --overlay-color: rgba(103, 58, 183, 0.6); --border-color: #673ab7;">
            <a href="{{ route('events.index', ['search' => 'Semarang']) }}" class="city-card-link-new">
                <span class="city-card-name-new">Semarang</span>
            </a>
        </div>
    </div>
</div>


{{-- FOOTER DILETAKKAN KEMBALI SEPERTI SEMULA --}}
<footer class="footer">
    <div class="container">
        <div class="text-center">
            <div class="d-flex justify-content-center align-items-center flex-wrap mb-2">
                <a href="{{ url('/') }}" class="footer-logo-link"><span class="footer-logo">ticketto.</span></a>
                <div class="social-icons ms-sm-4 mt-2 mt-sm-0">
                    <a href="#" class="text-white mx-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <p class="footer-copyright mb-0">&copy; 2025. PT Ticketto All Rights Reserved.</p>
        </div>
    </div>
</footer>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('cityCardsContainer');
        const scrollLeftBtn = document.getElementById('scrollLeftBtn');
        const scrollRightBtn = document.getElementById('scrollRightBtn');
        if (container && scrollLeftBtn && scrollRightBtn) {
            scrollRightBtn.addEventListener('click', function() {
                container.scrollBy({ left: 300, behavior: 'smooth' });
            });
            scrollLeftBtn.addEventListener('click', function() {
                container.scrollBy({ left: -300, behavior: 'smooth' });
            });
        }
    });
</script>
@endpush

@endsection
