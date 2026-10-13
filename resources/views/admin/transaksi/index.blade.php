@extends('admin.layouts.app')
@section('title', 'Transaksi setoran')
@section('content')
    <h2>Transaksi setoran</h2>
    <div class="panel table-wrap"><table>
        <thead><tr><th>Tanggal</th><th>Nasabah</th><th>Petugas</th><th>Total</th><th></th></tr></thead>
        <tbody>@forelse ($transaksi as $item)
            <tr><td>{{ $item->tanggal_setoran->format('d/m/Y H:i') }}</td><td>{{ $item->nasabah?->nama_siswa ?? '—' }}</td><td>{{ $item->petugas?->name ?? '—' }}</td><td>Rp {{ number_format((float) $item->total_nilai, 2, ',', '.') }}</td><td><a href="{{ route('admin.transaksi.show', $item) }}">Rincian</a></td></tr>
        @empty<tr><td colspan="5">Belum ada transaksi.</td></tr>@endforelse</tbody>
    </table>{{ $transaksi->links() }}</div>
@endsection
