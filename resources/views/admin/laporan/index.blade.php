@extends('admin.layouts.app')
@section('title', 'Laporan')
@section('content')
    <h2>Laporan transaksi setoran</h2>
    <form class="panel" method="get" action="{{ route('admin.laporan.index') }}">
        <div class="actions">
            <label for="mulai">Dari <input id="mulai" type="date" name="mulai" value="{{ request('mulai') }}"></label>
            <label for="sampai">Sampai <input id="sampai" type="date" name="sampai" value="{{ request('sampai') }}"></label>
            <button type="submit">Terapkan</button>
            <a class="button secondary" href="{{ route('admin.laporan.index') }}">Reset</a>
        </div>
    </form>
    <div class="cards">
        <section class="panel metric">Jumlah transaksi<strong>{{ number_format((int) $ringkasan->jumlah_transaksi) }}</strong></section>
        <section class="panel metric">Total nilai<strong>Rp {{ number_format((float) $ringkasan->total_nilai, 2, ',', '.') }}</strong></section>
        <section class="panel metric">Total berat<strong>{{ number_format((float) $totalBerat, 3, ',', '.') }} kg</strong></section>
    </div>
    <div class="panel table-wrap"><table>
        <thead><tr><th>Tanggal</th><th>Nasabah</th><th>Petugas</th><th>Berat (kg)</th><th>Total</th><th></th></tr></thead>
        <tbody>@forelse ($transaksi as $item)
            <tr>
                <td>{{ $item->tanggal_setoran->format('d/m/Y H:i') }}</td>
                <td>{{ $item->nasabah?->nama_siswa ?? '—' }}</td>
                <td>{{ $item->petugas?->name ?? '—' }}</td>
                <td>{{ number_format((float) $item->detailSetoran->sum('berat_kg'), 3, ',', '.') }}</td>
                <td>Rp {{ number_format((float) $item->total_nilai, 2, ',', '.') }}</td>
                <td><a href="{{ route('admin.transaksi.show', $item) }}">Rincian</a></td>
            </tr>
        @empty<tr><td colspan="6">Tidak ada transaksi pada rentang tanggal ini.</td></tr>@endforelse</tbody>
    </table>{{ $transaksi->links() }}</div>
@endsection
