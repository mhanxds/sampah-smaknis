@extends('admin.layouts.app')
@section('title', 'Ubah nasabah')
@section('content')
    <section class="panel"><h2>Ubah nasabah</h2>@include('admin.nasabah._form', ['nasabah' => $nasabah])</section>
@endsection
