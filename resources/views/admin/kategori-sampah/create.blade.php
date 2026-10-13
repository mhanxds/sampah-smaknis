@extends('admin.layouts.app')
@section('title', 'Tambah kategori')
@section('content')
    <section class="panel"><h2>Tambah kategori sampah</h2>@include('admin.kategori-sampah._form', ['kategoriSampah' => new \App\Models\KategoriSampah()])</section>
@endsection
