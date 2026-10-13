<form method="post" action="{{ $nasabah->exists ? route('admin.nasabah.update', $nasabah) : route('admin.nasabah.store') }}">
    @csrf
    @if ($nasabah->exists) @method('put') @endif
    <label for="nama_siswa">Nama siswa</label><input id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa', $nasabah->nama_siswa) }}" required maxlength="255">
    <label for="kelas">Kelas</label><input id="kelas" name="kelas" value="{{ old('kelas', $nasabah->kelas) }}" required maxlength="50">
    <label for="email">Email akun siswa</label><input id="email" type="email" name="email" value="{{ old('email', $nasabah->user?->email) }}" required maxlength="255">
    @unless ($nasabah->exists)
        <label for="password">Kata sandi awal</label><input id="password" type="password" name="password" required minlength="8">
    @endunless
    <div class="form-actions"><button type="submit">Simpan</button><a class="button secondary" href="{{ route('admin.nasabah.index') }}">Batal</a></div>
</form>
