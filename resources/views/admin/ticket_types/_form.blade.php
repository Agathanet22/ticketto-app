@csrf
<div class="mb-3">
    <label for="name" class="form-label">Nama Jenis Tiket (e.g., VIP, Reguler, Presale 1)</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $ticketType->name ?? '') }}" required>
    
    {{-- Kode ini akan menampilkan error untuk kolom 'name' --}}
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="price" class="form-label">Harga (IDR)</label>
        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $ticketType->price ?? '') }}" required min="0">
        
        {{-- Kode ini akan menampilkan error untuk kolom 'price' --}}
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="quota" class="form-label">Kuota (Jumlah Tiket)</label>
        <input type="number" class="form-control @error('quota') is-invalid @enderror" id="quota" name="quota" value="{{ old('quota', $ticketType->quota ?? '') }}" required min="1">

        {{-- Kode ini akan menampilkan error untuk kolom 'quota' --}}
        @error('quota')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-success">{{ $submitButtonText ?? 'Simpan' }}</button>
    <a href="{{ route('admin.events.ticket-types.index', $event ?? $ticketType->event) }}" class="btn btn-secondary">Batal</a>
</div>