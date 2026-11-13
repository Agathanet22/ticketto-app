@extends('layouts.app')

@section('title', 'Tambah Acara Baru')

@section('content')
<div class="container py-4">
    <h1>Tambah Acara Baru</h1>
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            {{-- Form ini diubah agar benar-benar berfungsi --}}
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                {{-- Memanggil form partial dan menentukan teks tombol --}}
                @include('admin.events._form', ['submitButtonText' => 'Simpan Acara'])
            </form>
        </div>
    </div>
</div>
@endsection
