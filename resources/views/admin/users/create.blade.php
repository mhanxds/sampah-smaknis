@extends('admin.layouts.app')

@section('title', 'Tambah pengguna')

@section('content')
    <section class="panel"><h2>Tambah pengguna</h2>@include('admin.users._form', ['user' => new \App\Models\User()])</section>
@endsection
