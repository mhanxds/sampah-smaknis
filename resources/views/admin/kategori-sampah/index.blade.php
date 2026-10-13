@extends('admin.layouts.app')
@section('title', 'Kategori sampah')
@section('content')
    <div class="actions"><h2>Kategori sampah</h2><a class="button" href="{{ route('admin.kategori-sampah.create') }}">Tambah kategori</a></div>
    <div class="panel table-wrap"><table>
        <thead><tr><th>Nama</th><th>Harga per kg</th><th>Aksi</th></tr></thead>
        <tbody>@forelse ($kategoriSampah as $kategori)
            <tr><td>{{ $kategori->nama_sampah }}</td><td>Rp {{ number_format((float) $kategori->harga_per_kg, 2, ',', '.') }}</td>
                <td><div class="actions">
                    <a href="{{ route('admin.kategori-sampah.show', $kategori) }}">Detail</a>
                    <a href="{{ route('admin.kategori-sampah.edit', $kategori) }}">Ubah</a>
                    <form method="post" action="{{ route('admin.kategori-sampah.destroy', $kategori) }}" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('delete')<button class="danger" type="submit">Hapus</button></form>
                </div></td>
            </tr>
        @empty<tr><td colspan="3">Belum ada kategori sampah.</td></tr>@endforelse</tbody>
    </table>{{ $kategoriSampah->links() }}</div>
@endsection
