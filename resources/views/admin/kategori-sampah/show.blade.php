@extends('admin.layouts.app')
@section('title', 'Detail kategori')
@section('content')
    <section class="panel">
        <h2>{{ $kategoriSampah->nama_sampah }}</h2>
        <p><strong>Harga per kilogram:</strong> Rp {{ number_format((float) $kategoriSampah->harga_per_kg, 2, ',', '.') }}</p>
        <p><strong>Jumlah detail setoran:</strong> {{ $kategoriSampah->detailSetoran()->count() }}</p>
        <a class="button secondary" href="{{ route('admin.kategori-sampah.index') }}">Kembali</a>
    </section>
@endsection
