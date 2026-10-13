@extends('admin.layouts.app')
@section('title', 'Ubah kategori')
@section('content')
    <section class="panel"><h2>Ubah kategori sampah</h2>@include('admin.kategori-sampah._form', ['kategoriSampah' => $kategoriSampah])</section>
@endsection
