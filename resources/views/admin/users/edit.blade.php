@extends('admin.layouts.app')

@section('title', 'Ubah pengguna')

@section('content')
    <section class="panel"><h2>Ubah pengguna</h2>@include('admin.users._form', ['user' => $user])</section>
@endsection
