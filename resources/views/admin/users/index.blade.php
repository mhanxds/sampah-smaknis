@extends('admin.layouts.app')

@section('title', 'Pengguna')

@section('content')
    <div class="actions"><h2>Pengguna</h2><a class="button" href="{{ route('admin.users.create') }}">Tambah pengguna</a></div>
    <div class="panel table-wrap">
        <table>
            <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->role }}</td>
                        <td><div class="actions">
                            <a href="{{ route('admin.users.edit', $user) }}">Ubah</a>
                            <form method="post" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf @method('delete') <button class="danger" type="submit">Hapus</button>
                            </form>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
@endsection
