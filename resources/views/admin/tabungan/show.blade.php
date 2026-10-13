@extends('admin.layouts.app')
@section('title', 'Detail tabungan')
@section('content')
    <section class="panel">
        <h2>Tabungan {{ $tabungan->nasabah?->nama_siswa ?? '' }}</h2>
        <p><strong>Kelas:</strong> {{ $tabungan->nasabah?->kelas ?? '—' }}</p>
        <p><strong>Saldo saat ini:</strong> Rp {{ number_format((float) $tabungan->saldo, 2, ',', '.') }}</p>
        <h3>Riwayat transaksi setoran</h3>
        <ul>@forelse ($tabungan->nasabah?->transaksiSetoran ?? [] as $transaksi)
            <li><a href="{{ route('admin.transaksi.show', $transaksi) }}">{{ $transaksi->tanggal_setoran->format('d/m/Y H:i') }}</a> — Rp {{ number_format((float) $transaksi->total_nilai, 2, ',', '.') }}</li>
        @empty<li>Belum ada transaksi.</li>@endforelse</ul>
        <a class="button secondary" href="{{ route('admin.tabungan.index') }}">Kembali</a>
    </section>
@endsection
