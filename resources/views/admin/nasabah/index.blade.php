@extends('admin.layouts.app')

@section('title', 'Nasabah')

@section('content')
    <div class="actions"><h2>Nasabah</h2><a class="button" href="{{ route('admin.nasabah.create') }}">Tambah nasabah</a></div>
    <div class="panel table-wrap"><table>
        <thead><tr><th>Nama siswa</th><th>Kelas</th><th>Email</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse ($nasabah as $item)
                <tr><td>{{ $item->nama_siswa }}</td><td>{{ $item->kelas }}</td><td>{{ $item->user?->email ?? '—' }}</td>
                    <td><div class="actions">
                        <a href="{{ route('admin.nasabah.show', $item) }}">Detail</a>
                        <a href="{{ route('admin.nasabah.edit', $item) }}">Ubah</a>
                        <form method="post" action="{{ route('admin.nasabah.destroy', $item) }}" onsubmit="return confirm('Hapus nasabah ini?')">@csrf @method('delete')<button class="danger" type="submit">Hapus</button></form>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada nasabah.</td></tr>
            @endforelse
        </tbody>
    </table>{{ $nasabah->links() }}</div>
@endsection
