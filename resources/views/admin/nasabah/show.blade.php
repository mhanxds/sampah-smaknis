@extends('admin.layouts.app')
@section('title', 'Detail nasabah')
@section('content')
    <section class="panel">
        <h2>{{ $nasabah->nama_siswa }}</h2>
        <p><strong>Kelas:</strong> {{ $nasabah->kelas }}</p>
        <p><strong>Email:</strong> {{ $nasabah->user?->email ?? '—' }}</p>
        <p><strong>Saldo:</strong> Rp {{ number_format((float) ($nasabah->tabungan?->saldo ?? 0), 2, ',', '.') }}</p>
        <h3>Riwayat setoran</h3>
        <ul>@forelse ($nasabah->transaksiSetoran as $transaksi)
            <li><a href="{{ route('admin.transaksi.show', $transaksi) }}">{{ $transaksi->tanggal_setoran->format('d/m/Y H:i') }}</a> — Rp {{ number_format((float) $transaksi->total_nilai, 2, ',', '.') }}</li>
        @empty<li>Belum ada transaksi.</li>@endforelse</ul>
        <a class="button secondary" href="{{ route('admin.nasabah.index') }}">Kembali</a>
    </section>
@endsection
