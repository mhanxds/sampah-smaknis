<form method="post" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
    @csrf
    @if ($user->exists) @method('put') @endif
    <label for="name">Nama</label>
    <input id="name" name="name" value="{{ old('name', $user->name) }}" required maxlength="255">
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255">
    <label for="role">Peran</label>
    <select id="role" name="role" required>
        @php
            $roles = ['admin_bank' => 'Admin Bank', 'petugas_bank_sampah' => 'Petugas Bank Sampah'];
        @endphp
        @if ($user->exists && $user->role === 'nasabah')
            @php
                $roles['nasabah'] = 'Nasabah';
            @endphp
        @endif
        @foreach ($roles as $value => $label)
            <option value="{{ $value }}" @selected(old('role', $user->role) === $value)>{{ $label }}</option>
        @endforeach
    </select>
    <label for="password">Kata sandi {{ $user->exists ? '(kosongkan jika tidak diubah)' : '' }}</label>
    <input id="password" type="password" name="password" {{ $user->exists ? '' : 'required' }} minlength="8">
    <div class="form-actions"><button type="submit">Simpan</button><a class="button secondary" href="{{ route('admin.users.index') }}">Batal</a></div>
</form>
