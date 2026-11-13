@csrf
<div class="mb-3">
    <label for="name" class="form-label">Nama Acara</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $event->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $event->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="date" class="form-label">Tanggal</label>
        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', isset($event->date) ? $event->date->format('Y-m-d') : '') }}" required>
        @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    {{-- INPUT WAKTU DITAMBAHKAN DI SINI --}}
    <div class="col-md-6 mb-3">
        <label for="time" class="form-label">Waktu</label>
        <input type="time" class="form-control @error('time') is-invalid @enderror" id="time" name="time" value="{{ old('time', isset($event->time) ? $event->time->format('H:i') : '') }}" required>
        @error('time') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="mb-3">
    <label for="location" class="form-label">Lokasi</label>
    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $event->location ?? '') }}" required>
    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="min_price" class="form-label">Harga Tiket Mulai Dari (Rp)</label>
        <input type="number" class="form-control @error('min_price') is-invalid @enderror" id="min_price" name="min_price" value="{{ old('min_price', $event->min_price ?? '') }}" min="0" required>
        @error('min_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="poster" class="form-label">Poster Acara</label>
        <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster" accept="image/*">
        @error('poster') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
@if(isset($event) && $event->poster)
<div class="mb-3">
    <label class="form-label">Poster Saat Ini:</label><br>
    <img src="{{ Storage::url($event->poster) }}" alt="Poster" class="img-thumbnail" style="max-width: 150px;">
</div>
@endif
<div class="d-grid gap-2">
    <button type="submit" class="btn btn-success">{{ $submitButtonText ?? 'Simpan' }}</button>
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Batal</a>
</div>
