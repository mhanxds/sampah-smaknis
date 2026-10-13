@extends('admin.layouts.app')
@section('title', 'Tabungan')
@section('content')
    <h2>Tabungan nasabah</h2>
    <div class="panel table-wrap"><table>
        <thead><tr><th>Nasabah</th><th>Kelas</th><th>Saldo</th><th></th></tr></thead>
        <tbody>@forelse ($tabungan as $item)
            <tr><td>{{ $item->nasabah?->nama_siswa ?? '—' }}</td><td>{{ $item->nasabah?->kelas ?? '—' }}</td><td>Rp {{ number_format((float) $item->saldo, 2, ',', '.') }}</td><td><a href="{{ route('admin.tabungan.show', $item) }}">Detail</a></td></tr>
        @empty<tr><td colspan="4">Belum ada data tabungan.</td></tr>@endforelse</tbody>
    </table>{{ $tabungan->links() }}</div>
@endsection
