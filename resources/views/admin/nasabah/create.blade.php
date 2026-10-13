@extends('admin.layouts.app')
@section('title', 'Tambah nasabah')
@section('content')
    <section class="panel"><h2>Tambah nasabah</h2>@include('admin.nasabah._form', ['nasabah' => new \App\Models\Nasabah()])</section>
@endsection
