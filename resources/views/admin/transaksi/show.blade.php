@extends('admin.layouts.app')
@section('title', 'Rincian transaksi')
@section('content')
    <section class="panel">
        <h2>Rincian transaksi #{{ $transaksi->getKey() }}</h2>
        <p><strong>Tanggal:</strong> {{ $transaksi->tanggal_setoran->format('d/m/Y H:i') }}</p>
        <p><strong>Nasabah:</strong> {{ $transaksi->nasabah?->nama_siswa ?? '—' }}</p>
        <p><strong>Petugas:</strong> {{ $transaksi->petugas?->name ?? '—' }}</p>
        <div class="table-wrap"><table>
            <thead><tr><th>Kategori</th><th>Berat (kg)</th><th>Harga/kg</th><th>Subtotal</th></tr></thead>
            <tbody>@forelse ($transaksi->detailSetoran as $detail)
                <tr><td>{{ $detail->kategoriSampah?->nama_sampah ?? '—' }}</td><td>{{ number_format((float) $detail->berat_kg, 3, ',', '.') }}</td><td>Rp {{ number_format((float) $detail->harga_per_kg, 2, ',', '.') }}</td><td>Rp {{ number_format((float) $detail->subtotal, 2, ',', '.') }}</td></tr>
            @empty<tr><td colspan="4">Tidak ada detail.</td></tr>@endforelse</tbody>
            <tfoot><tr><th colspan="3">Total transaksi</th><th>Rp {{ number_format((float) $transaksi->total_nilai, 2, ',', '.') }}</th></tr></tfoot>
        </table></div>
        <p><a class="button secondary" href="{{ route('admin.transaksi.index') }}">Kembali</a></p>
    </section>
@endsection
