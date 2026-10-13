<form method="post" action="{{ $kategoriSampah->exists ? route('admin.kategori-sampah.update', $kategoriSampah) : route('admin.kategori-sampah.store') }}">
    @csrf
    @if ($kategoriSampah->exists) @method('put') @endif
    <label for="nama_sampah">Nama kategori</label>
    <input id="nama_sampah" name="nama_sampah" value="{{ old('nama_sampah', $kategoriSampah->nama_sampah) }}" required maxlength="100">
    <label for="harga_per_kg">Harga per kilogram (Rp)</label>
    <input id="harga_per_kg" type="number" name="harga_per_kg" value="{{ old('harga_per_kg', $kategoriSampah->harga_per_kg) }}" min="0" step="0.01" required>
    <div class="form-actions"><button type="submit">Simpan</button><a class="button secondary" href="{{ route('admin.kategori-sampah.index') }}">Batal</a></div>
</form>
